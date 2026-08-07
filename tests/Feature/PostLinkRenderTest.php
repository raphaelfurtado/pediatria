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
}
