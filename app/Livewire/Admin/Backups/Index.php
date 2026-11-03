<?php

namespace App\Livewire\Admin\Backups;

use App\Models\SiteSetting;
use App\Services\DatabaseBackup;
use App\Services\MailStatus;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public bool $running = false;

    /** E-mail que recebe uma cópia de cada backup (cópia fora do servidor). */
    public string $backupEmail = '';

    /** Resultado do último teste de envio: ['ok' => bool, 'message' => string]. */
    public ?array $mailTest = null;

    public function mount(): void
    {
        $this->backupEmail = (string) SiteSetting::get(DatabaseBackup::EMAIL_SETTING, '');
    }

    public function createNow(): void
    {
        $this->running = true;

        try {
            $backup = new DatabaseBackup;
            $name = basename($backup->run());
            $message = 'Backup criado com sucesso!';

            try {
                if ($to = $backup->emailToConfigured($name)) {
                    $message .= " Cópia enviada para {$to}.";
                }
            } catch (\Throwable $e) {
                report($e);
                $message .= ' Mas o envio por e-mail falhou: '.$e->getMessage();
            }

            $this->dispatch('notify', $message);
        } catch (\Throwable $e) {
            $this->dispatch('notify', 'Falha ao gerar backup: '.$e->getMessage());
        }

        $this->running = false;
    }

    public function saveBackupEmail(): void
    {
        $this->validate(['backupEmail' => 'nullable|email|max:255'], [
            'backupEmail.email' => 'Informe um e-mail válido.',
        ]);

        SiteSetting::set(DatabaseBackup::EMAIL_SETTING, trim($this->backupEmail));

        $this->dispatch('notify', $this->backupEmail
            ? 'E-mail de backup salvo. Os próximos backups serão enviados para ele.'
            : 'Envio de backup por e-mail desativado.');
    }

    public function sendTestEmail(): void
    {
        $to = auth()->user()->email;

        if (! MailStatus::configured()) {
            $this->mailTest = ['ok' => false, 'message' => 'O servidor não está configurado para enviar e-mails (veja acima como resolver).'];

            return;
        }

        try {
            Mail::raw(
                "Este é um e-mail de teste enviado pelo painel do site da SOPAPE.\n\nSe você recebeu, o envio de e-mails está funcionando.",
                fn ($mail) => $mail->to($to)->subject('Teste de e-mail — site SOPAPE')
            );
            $this->mailTest = ['ok' => true, 'message' => "E-mail de teste enviado para {$to}. Confira a caixa de entrada (e o spam)."];
        } catch (\Throwable $e) {
            report($e);
            $this->mailTest = ['ok' => false, 'message' => 'Falha ao enviar: '.$e->getMessage()];
        }
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
            'mail' => MailStatus::summary(),
            'mailConfigured' => MailStatus::configured(),
        ]);
    }
}
