<?php

namespace App\Console\Commands;

use App\Services\DatabaseBackup;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:run {--keep=14 : Quantidade de backups a manter}';

    protected $description = 'Cria um backup (dump) do banco de dados em storage/app/backups';

    public function handle(): int
    {
        $this->info('Gerando backup do banco de dados...');

        $path = (new DatabaseBackup(keep: (int) $this->option('keep')))->run();

        $this->info("Backup criado com sucesso: {$path}");

        return self::SUCCESS;
    }
}
