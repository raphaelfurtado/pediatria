<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
