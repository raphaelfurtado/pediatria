<?php

namespace App\Console\Commands;

use App\Services\DatabaseBackup;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:run {--keep=14 : Quantidade de backups a manter}';

    protected $description = 'Cria um backup (dump) do banco de dados em storage/app/backups e envia cópia por e-mail, se configurado';

    public function handle(): int
    {
        $this->info('Gerando backup do banco de dados...');

        $backup = new DatabaseBackup(keep: (int) $this->option('keep'));
        $path = $backup->run();

        $this->info("Backup criado com sucesso: {$path}");

        // A cópia por e-mail é um extra: se falhar, o backup local continua valendo.
        try {
            $to = $backup->emailToConfigured(basename($path));
            $this->info($to ? "Cópia enviada por e-mail para {$to}." : 'Envio por e-mail não configurado.');
        } catch (\Throwable $e) {
            report($e);
            $this->warn('Falha ao enviar a cópia por e-mail: '.$e->getMessage());
        }

        return self::SUCCESS;
    }
}
