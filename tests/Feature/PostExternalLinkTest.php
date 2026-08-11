<?php

namespace Tests\Feature;

use App\Livewire\Admin\Posts\Form as PostForm;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostExternalLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_link_helper_returns_external_url_when_set(): void
    {
        $external = Post::factory()->make(['external_url' => 'https://sindmepa.org.br/materia', 'slug' => 'x']);
        $internal = Post::factory()->make(['external_url' => null, 'slug' => 'minha-noticia']);

        $this->assertTrue($external->isExternal());
        $this->assertSame('https://sindmepa.org.br/materia', $external->link());

        $this->assertFalse($internal->isExternal());
        $this->assertStringContainsString('/noticias/minha-noticia', $internal->link());
    }

    public function test_home_card_points_to_external_url(): void
    {
        Post::factory()->create([
            'title' => 'Matéria republicada',
            'slug' => 'materia-republicada',
            'is_featured' => true,
            'published_at' => now()->subDay(),
            'external_url' => 'https://sindmepa.org.br/noticia/exemplo',
        ]);

        $response = $this->get('/');

        $response->assertSee('https://sindmepa.org.br/noticia/exemplo', false);
        $response->assertSee('target="_blank"', false);
    }

    public function test_slug_is_sanitised_and_external_url_saved(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(PostForm::class)
            ->set('title', 'Semana Mundial')
            ->set('slug', 'https://sindmepa.org.br/noticia/semana-mundial')
            ->set('content', 'Conteúdo.')
            ->set('category', 'Notícias')
            ->set('status', 'draft')
            ->set('external_url', 'https://sindmepa.org.br/noticia/semana-mundial')
            ->call('save');

        $post = Post::firstOrFail();

        // Slug nunca é uma URL.
        $this->assertStringNotContainsString('://', $post->slug);
        $this->assertStringNotContainsString('/', $post->slug);
        $this->assertSame('https://sindmepa.org.br/noticia/semana-mundial', $post->external_url);
    }

    public function test_invalid_external_url_is_rejected(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(PostForm::class)
            ->set('title', 'Teste')
            ->set('content', 'Conteúdo.')
            ->set('category', 'Notícias')
            ->set('status', 'draft')
            ->set('external_url', 'nao-e-url')
            ->call('save')
            ->assertHasErrors(['external_url']);
    }
}
