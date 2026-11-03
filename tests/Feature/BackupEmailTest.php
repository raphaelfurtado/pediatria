<?php

namespace Tests\Feature;

use App\Livewire\Admin\Backups\Index as BackupsIndex;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\DatabaseBackup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class BackupEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    /** Servidor "configurado" (mailer smtp), mas entregando em memória para o teste inspecionar. */
    protected function useWorkingMailer(): void
    {
        config(['mail.default' => 'smtp', 'mail.mailers.smtp.transport' => 'array']);
    }

    /** @return \Illuminate\Support\Collection<int, \Symfony\Component\Mailer\SentMessage> */
    protected function sentMessages()
    {
        return Mail::mailer('smtp')->getSymfonyTransport()->messages();
    }

    public function test_backup_command_emails_a_copy_when_configured(): void
    {
        $this->useWorkingMailer();
        SiteSetting::set(DatabaseBackup::EMAIL_SETTING, 'ti@sopape.test');

        $this->artisan('backup:run')
            ->expectsOutputToContain('Cópia enviada por e-mail para ti@sopape.test')
            ->assertSuccessful();

        $email = $this->sentMessages()->first()->getOriginalMessage();
        $this->assertSame('ti@sopape.test', $email->getTo()[0]->getAddress());
        $this->assertStringEndsWith('.sql.gz', $email->getAttachments()[0]->getFilename());
    }

    public function test_backup_command_skips_email_when_server_cannot_send(): void
    {
        config(['mail.default' => 'log']);
        SiteSetting::set(DatabaseBackup::EMAIL_SETTING, 'ti@sopape.test');

        $this->artisan('backup:run')
            ->expectsOutputToContain('Envio por e-mail não configurado.')
            ->assertSuccessful();

        $this->assertCount(1, Storage::disk('local')->files('backups'));
    }

    public function test_admin_saves_backup_email(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(BackupsIndex::class)
            ->set('backupEmail', 'invalido')
            ->call('saveBackupEmail')
            ->assertHasErrors('backupEmail')
            ->set('backupEmail', 'ti@sopape.test')
            ->call('saveBackupEmail')
            ->assertHasNoErrors();

        $this->assertSame('ti@sopape.test', SiteSetting::get(DatabaseBackup::EMAIL_SETTING));
    }

    public function test_mail_diagnostic_flags_log_mailer(): void
    {
        config(['mail.default' => 'log']);
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(BackupsIndex::class)
            ->assertSee('Não configurado')
            ->call('sendTestEmail')
            ->assertSet('mailTest.ok', false);
    }

    public function test_test_email_is_sent_when_configured(): void
    {
        $this->useWorkingMailer();
        $admin = User::factory()->admin()->create(['email' => 'admin@sopape.test']);
        $this->actingAs($admin);

        Livewire::test(BackupsIndex::class)
            ->assertSee('Configurado')
            ->call('sendTestEmail')
            ->assertSet('mailTest.ok', true);

        $this->assertSame('admin@sopape.test', $this->sentMessages()->first()->getOriginalMessage()->getTo()[0]->getAddress());
    }

    public function test_backups_page_is_admin_only(): void
    {
        $this->actingAs(User::factory()->editor()->create())
            ->get(route('admin.backups.index'))
            ->assertForbidden();
    }
}
