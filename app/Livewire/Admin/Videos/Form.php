<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Video;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public $videoId;

    public $title;

    public $video_link;

    public $description;

    public $is_featured = false;

    public $is_active = true;

    // Derivados do link (para o preview ao vivo).
    public $previewProvider;

    public $previewVideoId;

    public function mount($id = null)
    {
        if ($id) {
            $video = Video::findOrFail($id);
            $this->videoId = $video->id;
            $this->title = $video->title;
            $this->video_link = $video->watchUrl();
            $this->description = $video->description;
            $this->is_featured = (bool) $video->is_featured;
            $this->is_active = (bool) $video->is_active;
            $this->previewProvider = $video->provider;
            $this->previewVideoId = $video->youtube_id;
        }
    }

    public function updatedVideoLink($value): void
    {
        if (blank($value)) {
            $this->previewProvider = null;
            $this->previewVideoId = null;

            return;
        }

        $ref = Video::parseReference($value);
        $this->previewProvider = $ref['provider'];
        $this->previewVideoId = $ref['id'];
    }

    public function getPreviewEmbedUrlProperty(): ?string
    {
        if (! $this->previewVideoId) {
            return null;
        }

        return $this->previewProvider === 'vimeo'
            ? "https://player.vimeo.com/video/{$this->previewVideoId}"
            : "https://www.youtube.com/embed/{$this->previewVideoId}";
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'video_link' => 'required|string|max:255',
        ], [
            'video_link.required' => 'Cole o link do vídeo (YouTube ou Vimeo).',
        ]);

        $ref = Video::parseReference($this->video_link);

        $data = [
            'title' => $this->title,
            'youtube_id' => $ref['id'],
            'provider' => $ref['provider'],
            'thumbnail_url' => $this->resolveThumbnail($ref),
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->videoId) {
            Video::find($this->videoId)->update($data);
            session()->flash('notify', 'Vídeo atualizado com sucesso!');
        } else {
            Video::create($data);
            session()->flash('notify', 'Vídeo criado com sucesso!');
        }

        return redirect()->route('admin.videos.index');
    }

    /**
     * O YouTube tem miniatura por URL fixa; o Vimeo precisa do oEmbed.
     */
    protected function resolveThumbnail(array $ref): ?string
    {
        if ($ref['provider'] !== 'vimeo') {
            return null; // YouTube: computado no model
        }

        try {
            $response = Http::timeout(5)->get('https://vimeo.com/api/oembed.json', [
                'url' => "https://vimeo.com/{$ref['id']}",
            ]);

            return $response->ok() ? ($response->json('thumbnail_url') ?: null) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.videos.form');
    }
}
