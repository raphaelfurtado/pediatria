<?php

namespace Tests\Feature;

use App\Livewire\Admin\Posts\Form as PostForm;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_link_helper_resolves_internal_route(): void
    {
        $post = Post::factory()->make(['slug' => 'minha-noticia']);

        $this->assertFalse($post->isExternal());
        $this->assertStringContainsString('/noticias/minha-noticia', $post->link());
    }

    public function test_featured_card_links_to_the_article(): void
    {
        $post = Post::factory()->create([
            'title' => 'Notícia em destaque',
            'slug' => 'noticia-destaque',
            'is_featured' => true,
            'published_at' => now()->subDay(),
        ]);

        $this->get('/')->assertSee(route('posts.show', $post->slug), false);
    }

    public function test_slug_is_sanitised_on_save(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(PostForm::class)
            ->set('title', 'Semana Mundial')
            ->set('slug', 'https://sindmepa.org.br/noticia/semana-mundial')
            ->set('content', 'Conteúdo.')
            ->set('category', 'Notícias')
            ->set('status', 'draft')
            ->call('save');

        $post = Post::firstOrFail();

        $this->assertStringNotContainsString('://', $post->slug);
        $this->assertStringNotContainsString('/', $post->slug);
    }
}
