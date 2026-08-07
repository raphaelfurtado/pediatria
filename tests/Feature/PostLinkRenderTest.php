<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostLinkRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_links_in_content_are_preserved_and_rendered(): void
    {
        $post = Post::factory()->create([
            'slug' => 'noticia-com-link',
            'published_at' => now()->subDay(),
            'content' => '<p>Veja <a href="https://g1.globo.com/exemplo">a reportagem</a>.</p>',
        ]);

        $response = $this->get('/noticias/'.$post->slug);

        $response->assertOk();
        $response->assertSee('href="https://g1.globo.com/exemplo"', false);
        $response->assertSee('a reportagem');
    }

    public function test_content_link_styling_is_present(): void
    {
        $post = Post::factory()->create([
            'slug' => 'noticia-estilo-link',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/noticias/'.$post->slug)->assertSee('.prose a', false);
    }

    public function test_article_without_image_uses_branded_placeholder(): void
    {
        $post = Post::factory()->create([
            'slug' => 'noticia-sem-imagem',
            'published_at' => now()->subDay(),
            'image_path' => null,
        ]);

        $response = $this->get('/noticias/'.$post->slug);

        $response->assertOk();
        $response->assertSee('data-sopape-placeholder', false);
        // Sem fallbacks externos que podiam quebrar.
        $response->assertDontSee('images.unsplash.com');
        $response->assertDontSee('via.placeholder.com');
        $response->assertDontSee('lh3.googleusercontent.com');
    }

    public function test_article_with_image_renders_the_image(): void
    {
        $post = Post::factory()->create([
            'slug' => 'noticia-com-imagem',
            'published_at' => now()->subDay(),
            'image_path' => '/storage/posts/exemplo.webp',
        ]);

        $this->get('/noticias/'.$post->slug)->assertSee('/storage/posts/exemplo.webp', false);
    }

    public function test_newsletter_card_is_hidden_by_default(): void
    {
        $post = Post::factory()->create([
            'slug' => 'noticia-sem-news',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/noticias/'.$post->slug)->assertDontSee('Receba novidades');
    }

    public function test_newsletter_card_appears_when_enabled(): void
    {
        \App\Models\SiteSetting::set('marketing_enabled', '1');

        $post = Post::factory()->create([
            'slug' => 'noticia-com-news',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/noticias/'.$post->slug)->assertSee('Receba novidades');
    }
}
