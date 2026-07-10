<?php

namespace App\Livewire\Admin\Backups;

use App\Services\DatabaseBackup;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public bool $running = false;

    public function createNow(): void
    {
        $this->running = true;

        try {
            (new DatabaseBackup)->run();
            $this->dispatch('notify', 'Backup criado com sucesso!');
        } catch (\Throwable $e) {
            $this->dispatch('notify', 'Falha ao gerar backup: '.$e->getMessage());
        }

        $this->running = false;
    }

    public function delete(string $name): void
    {
        (new DatabaseBackup)->delete($name);
        $this->dispatch('notify', 'Backup removido.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.backups.index', [
            'backups' => (new DatabaseBackup)->backups(),
        ]);
    }
}
