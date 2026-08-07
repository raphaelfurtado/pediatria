<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Posts\Form as PostForm;
use App\Livewire\Admin\Posts\Index as PostIndex;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostsWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    // --- Salvar e continuar / voltar ---------------------------------------

    public function test_save_and_exit_returns_to_list(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(PostForm::class)
            ->set('title', 'Sai para a lista')
            ->set('slug', 'sai-lista')
            ->set('content', 'x')
            ->set('category', 'Notícias')
            ->set('status', 'draft')
            ->call('save', true)
            ->assertRedirect(route('admin.posts.index'));
    }

    public function test_updating_stays_on_the_page(): void
    {
        $this->actingAs($this->admin());
        $post = Post::factory()->create(['published_at' => now()->subDay()]);

        Livewire::test(PostForm::class, ['id' => $post->id])
            ->set('title', 'Título Atualizado')
            ->call('save')
            ->assertNoRedirect();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Título Atualizado',
        ]);
    }

    public function test_featured_toggle_is_saved(): void
    {
        $this->actingAs($this->admin());
        $post = Post::factory()->create(['is_featured' => false, 'published_at' => now()->subDay()]);

        Livewire::test(PostForm::class, ['id' => $post->id])
            ->set('is_featured', true)
            ->call('save');

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'is_featured' => 1]);
    }

    // --- Home: card grande -------------------------------------------------

    public function test_home_big_card_prefers_featured_post(): void
    {
        $featured = Post::factory()->create(['is_featured' => true, 'published_at' => now()->subDays(10)]);
        Post::factory()->create(['is_featured' => false, 'published_at' => now()->subDay()]);

        $this->get('/')->assertViewHas('featuredPost', fn ($p) => $p->id === $featured->id);
    }

    public function test_home_big_card_falls_back_to_latest_when_none_featured(): void
    {
        Post::factory()->create(['is_featured' => false, 'published_at' => now()->subDays(5)]);
        $newest = Post::factory()->create(['is_featured' => false, 'published_at' => now()->subDay()]);

        $this->get('/')->assertViewHas('featuredPost', fn ($p) => $p->id === $newest->id);
    }

    // --- Seleção múltipla / lixeira ----------------------------------------

    public function test_bulk_delete_moves_posts_to_trash(): void
    {
        $this->actingAs($this->admin());
        $a = Post::factory()->create();
        $b = Post::factory()->create();

        Livewire::test(PostIndex::class)
            ->set('selected', [(string) $a->id, (string) $b->id])
            ->call('deleteSelected');

        $this->assertSoftDeleted('posts', ['id' => $a->id]);
        $this->assertSoftDeleted('posts', ['id' => $b->id]);
    }

    public function test_restore_brings_post_back_from_trash(): void
    {
        $this->actingAs($this->admin());
        $post = Post::factory()->create();
        $post->delete();

        Livewire::test(PostIndex::class)->call('restore', $post->id);

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => null]);
    }

    public function test_force_delete_removes_permanently(): void
    {
        $this->actingAs($this->admin());
        $post = Post::factory()->create();
        $post->delete();

        Livewire::test(PostIndex::class)->call('forceDeleteRow', $post->id);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_trash_tab_shows_only_deleted_posts(): void
    {
        $this->actingAs($this->admin());
        Post::factory()->create(['title' => 'NOTICIA ATIVA VISIVEL', 'published_at' => now()->subDay()]);
        $deleted = Post::factory()->create(['title' => 'NOTICIA NA LIXEIRA']);
        $deleted->delete();

        Livewire::test(PostIndex::class)
            ->assertSee('NOTICIA ATIVA VISIVEL')
            ->assertDontSee('NOTICIA NA LIXEIRA')
            ->call('setTrashed', true)
            ->assertSee('NOTICIA NA LIXEIRA')
            ->assertDontSee('NOTICIA ATIVA VISIVEL');
    }
}
