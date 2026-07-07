<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeFeaturedTest extends TestCase
{
    use RefreshDatabase;

    public function test_featured_active_video_appears_on_home(): void
    {
        Video::factory()->create([
            'title' => 'VIDEO EM DESTAQUE NA HOME',
            'is_active' => true,
            'is_featured' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('VIDEO EM DESTAQUE NA HOME');
    }

    public function test_non_featured_video_is_not_on_home(): void
    {
        Video::factory()->create([
            'title' => 'VIDEO SEM DESTAQUE',
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->get('/')->assertDontSee('VIDEO SEM DESTAQUE');
    }

    public function test_inactive_featured_video_is_not_on_home(): void
    {
        Video::factory()->create([
            'title' => 'VIDEO INATIVO DESTAQUE',
            'is_active' => false,
            'is_featured' => true,
        ]);

        $this->get('/')->assertDontSee('VIDEO INATIVO DESTAQUE');
    }

    public function test_featured_post_appears_on_home(): void
    {
        Post::factory()->create([
            'title' => 'NOTICIA EM DESTAQUE PRINCIPAL',
            'is_featured' => true,
            'published_at' => now()->subDay(),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('NOTICIA EM DESTAQUE PRINCIPAL');
    }
}
