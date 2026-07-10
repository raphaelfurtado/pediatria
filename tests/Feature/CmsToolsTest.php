<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Services\DatabaseBackup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsToolsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    // --- Publicação agendada / rascunho / preview -------------------------

    public function test_draft_post_is_hidden_publicly_but_previewable_by_admin(): void
    {
        $post = Post::factory()->create([
            'title' => 'RASCUNHO INTERNO SOPAPE',
            'slug' => 'rascunho-interno',
            'published_at' => null,
        ]);

        // Público não vê o rascunho.
        $this->get('/noticias/'.$post->slug)->assertNotFound();

        // Admin consegue pré-visualizar.
        $this->actingAs($this->admin())
            ->get('/admin/posts/'.$post->id.'/preview')
            ->assertOk()
            ->assertSee('RASCUNHO INTERNO SOPAPE')
            ->assertSee('Modo pré-visualização');
    }

    public function test_scheduled_post_is_hidden_until_its_date(): void
    {
        $post = Post::factory()->create([
            'title' => 'NOTICIA AGENDADA FUTURA',
            'slug' => 'noticia-agendada',
            'published_at' => now()->addDays(3),
        ]);

        $this->get('/noticias/'.$post->slug)->assertNotFound();
        $this->get('/')->assertDontSee('NOTICIA AGENDADA FUTURA');

        $this->actingAs($this->admin())
            ->get('/admin/posts/'.$post->id.'/preview')
            ->assertOk()
            ->assertSee('será publicada em');
    }

    // --- Backup ------------------------------------------------------------

    public function test_backup_creates_gzip_and_keeps_only_recent(): void
    {
        Storage::fake('local');

        // Backups antigos que devem ser podados (keep = 2).
        Storage::disk('local')->put('backups/backup-2026-01-01_000000.sql.gz', 'old');
        Storage::disk('local')->put('backups/backup-2026-01-02_000000.sql.gz', 'old');
        Storage::disk('local')->put('backups/backup-2026-01-03_000000.sql.gz', 'old');

        $path = (new DatabaseBackup(keep: 2))->run();

        $this->assertTrue(Storage::disk('local')->exists($path));

        $files = Storage::disk('local')->files('backups');
        $this->assertCount(2, $files, 'Deveria manter apenas os 2 backups mais recentes.');
    }

    public function test_backup_download_is_admin_only(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('backups/backup-2026-07-10_030000.sql.gz', gzencode('dump'));

        $editor = User::factory()->create(['role' => 'editor']);
        $this->actingAs($editor)
            ->get('/admin/backups/backup-2026-07-10_030000.sql.gz/download')
            ->assertForbidden();

        $this->actingAs($this->admin())
            ->get('/admin/backups/backup-2026-07-10_030000.sql.gz/download')
            ->assertOk();
    }

    public function test_backup_rejects_path_traversal_names(): void
    {
        Storage::fake('local');

        $this->expectException(\RuntimeException::class);
        (new DatabaseBackup)->delete('../../.env');
    }

    // --- Log de auditoria --------------------------------------------------

    public function test_creating_content_is_recorded_in_activity_log(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin);

        Post::factory()->create(['title' => 'POST QUE GERA LOG']);

        $this->assertDatabaseHas('activity_logs', [
            'event' => 'created',
            'subject_type' => Post::class,
            'user_id' => $admin->id,
        ]);
    }

    public function test_activity_page_renders_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/atividades')
            ->assertOk()
            ->assertSee('Registro de Atividades');
    }

    public function test_activity_page_is_blocked_for_editor(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)
            ->get('/admin/atividades')
            ->assertForbidden();
    }
}
