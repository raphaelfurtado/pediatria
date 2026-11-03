<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Pure-PHP (PDO) logical database backup.
 *
 * Avoids depending on the mysqldump binary or exec(), which are frequently
 * disabled on shared hosting. Dumps schema + data to a gzipped .sql file and
 * keeps only the most recent N backups.
 */
class DatabaseBackup
{
    /** Acima disso não anexamos (o Gmail recusa anexos de mais de 25MB). */
    public const MAX_ATTACHMENT_BYTES = 20 * 1024 * 1024;

    /** Configuração (SiteSetting) com o e-mail que recebe a cópia de cada backup. */
    public const EMAIL_SETTING = 'backup_email';

    public function __construct(
        protected string $disk = 'local',
        protected string $directory = 'backups',
        protected int $keep = 14,
    ) {}

    /**
     * Create a new backup and return its path relative to the disk.
     */
    public function run(): string
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();

        $sql = match ($driver) {
            'mysql', 'mariadb' => $this->dumpMysql($connection),
            'sqlite' => $this->dumpSqlite($connection),
            default => throw new RuntimeException("Backup não suportado para o driver de banco: {$driver}"),
        };

        $filename = $this->directory.'/backup-'.Carbon::now()->format('Y-m-d_His').'.sql.gz';
        Storage::disk($this->disk)->put($filename, (string) gzencode($sql, 6));

        $this->prune();

        return $filename;
    }

    /**
     * Backups on the disk, newest first.
     *
     * @return array<int, array{name: string, size: int, created_at: \Illuminate\Support\Carbon}>
     */
    public function backups(): array
    {
        $disk = Storage::disk($this->disk);

        return collect($disk->files($this->directory))
            ->filter(fn ($file) => Str::endsWith($file, '.sql.gz'))
            ->map(fn ($file) => [
                'name' => basename($file),
                'size' => $disk->size($file),
                'created_at' => Carbon::createFromTimestamp($disk->lastModified($file)),
            ])
            ->sortByDesc('name')
            ->values()
            ->all();
    }

    /**
     * Envia uma cópia do backup por e-mail — a cópia "fora do servidor", que
     * sobrevive se a hospedagem perder os arquivos. Lança exceção se o envio falhar.
     */
    public function emailTo(string $name, string $to): void
    {
        $path = $this->pathFor($name);
        $attach = filesize($path) <= self::MAX_ATTACHMENT_BYTES;
        $date = Carbon::now()->translatedFormat('d/m/Y \à\s H:i');

        $body = "Backup automático do banco de dados do site da SOPAPE, gerado em {$date}.\n\n"
            .($attach
                ? "O arquivo segue em anexo ({$name}). Guarde este e-mail: ele é a cópia de segurança fora do servidor.\n\n"
                : "O arquivo ficou grande demais para anexar. Baixe-o no painel em Sistema > Backups ({$name}).\n\n")
            .'Atenção: o arquivo contém todos os dados do site, inclusive cadastros de usuários. Não encaminhe.';

        Mail::raw($body, function ($mail) use ($to, $path, $name, $attach) {
            $mail->to($to)->subject('Backup do site SOPAPE — '.Carbon::now()->format('d/m/Y'));

            if ($attach) {
                $mail->attach($path, ['as' => $name, 'mime' => 'application/gzip']);
            }
        });
    }

    /**
     * Envia a cópia ao e-mail configurado no painel. Retorna o destinatário, ou
     * null quando não há e-mail configurado ou o servidor não envia e-mails.
     */
    public function emailToConfigured(string $name): ?string
    {
        $to = SiteSetting::get(self::EMAIL_SETTING);

        if (! $to || ! MailStatus::configured()) {
            return null;
        }

        $this->emailTo($name, $to);

        return $to;
    }

    /**
     * Delete a single backup by its (validated) basename.
     */
    public function delete(string $name): void
    {
        Storage::disk($this->disk)->delete($this->directory.'/'.$this->safeName($name));
    }

    /**
     * Absolute filesystem path of a backup for downloading.
     */
    public function pathFor(string $name): string
    {
        return Storage::disk($this->disk)->path($this->directory.'/'.$this->safeName($name));
    }

    public function exists(string $name): bool
    {
        return Storage::disk($this->disk)->exists($this->directory.'/'.$this->safeName($name));
    }

    /**
     * Guard against path traversal — only a plain backup filename is allowed.
     */
    protected function safeName(string $name): string
    {
        $base = basename($name);

        if (! Str::isMatch('/^backup-[\d_-]+\.sql\.gz$/', $base)) {
            throw new RuntimeException('Nome de backup inválido.');
        }

        return $base;
    }

    protected function dumpMysql($connection): string
    {
        $pdo = $connection->getPdo();
        $out = "-- SOPAPE database backup\n";
        $out .= '-- Database: '.$connection->getDatabaseName()."\n";
        $out .= '-- Generated: '.Carbon::now()->toDateTimeString()."\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($connection->select('SHOW TABLES') as $tableRow) {
            $table = array_values((array) $tableRow)[0];

            $createRow = (array) $connection->selectOne("SHOW CREATE TABLE `{$table}`");
            $create = $createRow['Create Table'] ?? $createRow['Create View'] ?? null;

            $out .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $out .= $create.";\n\n";

            foreach ($connection->select("SELECT * FROM `{$table}`") as $row) {
                $row = (array) $row;
                $columns = implode(', ', array_map(fn ($c) => "`{$c}`", array_keys($row)));
                $values = implode(', ', array_map(
                    fn ($v) => is_null($v) ? 'NULL' : $pdo->quote((string) $v),
                    array_values($row)
                ));
                $out .= "INSERT INTO `{$table}` ({$columns}) VALUES ({$values});\n";
            }
            $out .= "\n";
        }

        $out .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $out;
    }

    protected function dumpSqlite($connection): string
    {
        $pdo = $connection->getPdo();
        $out = "-- SOPAPE database backup (sqlite)\n";
        $out .= '-- Generated: '.Carbon::now()->toDateTimeString()."\n\n";

        $tables = $connection->select(
            "SELECT name, sql FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'"
        );

        foreach ($tables as $tableRow) {
            $tableRow = (array) $tableRow;
            $name = $tableRow['name'];

            $out .= "DROP TABLE IF EXISTS \"{$name}\";\n";
            $out .= $tableRow['sql'].";\n";

            foreach ($connection->select("SELECT * FROM \"{$name}\"") as $row) {
                $row = (array) $row;
                $columns = implode(', ', array_map(fn ($c) => "\"{$c}\"", array_keys($row)));
                $values = implode(', ', array_map(
                    fn ($v) => is_null($v) ? 'NULL' : $pdo->quote((string) $v),
                    array_values($row)
                ));
                $out .= "INSERT INTO \"{$name}\" ({$columns}) VALUES ({$values});\n";
            }
            $out .= "\n";
        }

        return $out;
    }

    protected function prune(): void
    {
        $disk = Storage::disk($this->disk);

        $files = collect($disk->files($this->directory))
            ->filter(fn ($file) => Str::endsWith($file, '.sql.gz'))
            ->sort()
            ->values();

        $excess = $files->count() - $this->keep;

        if ($excess > 0) {
            $files->take($excess)->each(fn ($file) => $disk->delete($file));
        }
    }
}
