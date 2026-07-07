<?php

namespace Tests\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_video_is_listed(): void
    {
        Video::factory()->create([
            'title' => 'VIDEO PUBLICO ATIVO',
            'is_active' => true,
        ]);

        $this->get('/videos')
            ->assertOk()
            ->assertSee('VIDEO PUBLICO ATIVO');
    }

    public function test_inactive_video_is_hidden(): void
    {
        Video::factory()->create([
            'title' => 'VIDEO PUBLICO INATIVO',
            'is_active' => false,
        ]);

        $this->get('/videos')->assertDontSee('VIDEO PUBLICO INATIVO');
    }
}
