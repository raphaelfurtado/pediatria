<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_load_with_empty_database(): void
    {
        $urls = ['/', '/noticias', '/eventos', '/galeria', '/videos', '/biblioteca', '/sobre'];

        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_published_post_detail_page_loads(): void
    {
        $post = Post::factory()->create(['published_at' => now()->subDay()]);

        $this->get('/noticias/'.$post->slug)
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_unpublished_post_is_not_reachable(): void
    {
        $post = Post::factory()->create(['published_at' => null]);

        $this->get('/noticias/'.$post->slug)->assertNotFound();
    }
}
