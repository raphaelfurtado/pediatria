<?php

namespace Tests\Feature;

use App\Livewire\Admin\Videos\Form;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class VideoLinkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider referenceProvider
     */
    public function test_parse_reference_detects_provider_and_id(string $input, string $provider, string $id): void
    {
        $ref = Video::parseReference($input);

        $this->assertSame($provider, $ref['provider']);
        $this->assertSame($id, $ref['id']);
    }

    public static function referenceProvider(): array
    {
        return [
            'youtube watch' => ['https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'youtube', 'dQw4w9WgXcQ'],
            'youtu.be' => ['https://youtu.be/dQw4w9WgXcQ', 'youtube', 'dQw4w9WgXcQ'],
            'youtube embed' => ['https://www.youtube.com/embed/dQw4w9WgXcQ', 'youtube', 'dQw4w9WgXcQ'],
            'youtube shorts' => ['https://www.youtube.com/shorts/dQw4w9WgXcQ', 'youtube', 'dQw4w9WgXcQ'],
            'bare youtube id' => ['dQw4w9WgXcQ', 'youtube', 'dQw4w9WgXcQ'],
            'vimeo url' => ['https://vimeo.com/76979871', 'vimeo', '76979871'],
            'vimeo player' => ['https://player.vimeo.com/video/76979871', 'vimeo', '76979871'],
            'bare numeric = vimeo' => ['76979871', 'vimeo', '76979871'],
        ];
    }

    public function test_embed_and_watch_urls_per_provider(): void
    {
        $yt = new Video(['youtube_id' => 'abc12345678', 'provider' => 'youtube']);
        $this->assertSame('https://www.youtube.com/embed/abc12345678', $yt->embedUrl());
        $this->assertSame('https://www.youtube.com/watch?v=abc12345678', $yt->watchUrl());
        $this->assertStringContainsString('img.youtube.com', $yt->thumbUrl());

        $vi = new Video(['youtube_id' => '76979871', 'provider' => 'vimeo']);
        $this->assertSame('https://player.vimeo.com/video/76979871', $vi->embedUrl());
        $this->assertSame('https://vimeo.com/76979871', $vi->watchUrl());
        $this->assertNull($vi->thumbUrl()); // sem thumbnail salva
    }

    public function test_admin_creates_youtube_video_from_full_link(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Form::class)
            ->set('title', 'Vídeo YouTube')
            ->set('video_link', 'https://youtu.be/dQw4w9WgXcQ')
            ->call('save')
            ->assertRedirect(route('admin.videos.index'));

        $this->assertDatabaseHas('videos', [
            'title' => 'Vídeo YouTube',
            'youtube_id' => 'dQw4w9WgXcQ',
            'provider' => 'youtube',
        ]);
    }

    public function test_admin_creates_vimeo_video_and_fetches_thumbnail(): void
    {
        Http::fake([
            'vimeo.com/api/oembed.json*' => Http::response([
                'thumbnail_url' => 'https://i.vimeocdn.com/video/12345_640.jpg',
            ], 200),
        ]);

        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Form::class)
            ->set('title', 'Vídeo Vimeo')
            ->set('video_link', 'https://vimeo.com/76979871')
            ->call('save')
            ->assertRedirect(route('admin.videos.index'));

        $this->assertDatabaseHas('videos', [
            'title' => 'Vídeo Vimeo',
            'youtube_id' => '76979871',
            'provider' => 'vimeo',
            'thumbnail_url' => 'https://i.vimeocdn.com/video/12345_640.jpg',
        ]);
    }

    public function test_editing_prefills_link_from_existing_video(): void
    {
        $video = Video::factory()->create([
            'youtube_id' => 'dQw4w9WgXcQ',
            'provider' => 'youtube',
        ]);

        Livewire::test(Form::class, ['id' => $video->id])
            ->assertSet('video_link', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    }
}
