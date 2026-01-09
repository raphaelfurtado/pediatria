<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Video;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Form extends Component
{
    public $videoId;
    public $title;
    public $youtube_id;
    public $description;
    public $is_featured = false;
    public $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $video = Video::findOrFail($id);
            $this->videoId = $video->id;
            $this->title = $video->title;
            $this->youtube_id = $video->youtube_id;
            $this->description = $video->description;
            $this->is_featured = (bool) $video->is_featured;
            $this->is_active = (bool) $video->is_active;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'youtube_id' => 'required|string|max:50',
        ]);

        $data = [
            'title' => $this->title,
            'youtube_id' => $this->youtube_id,
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->videoId) {
            $video = Video::find($this->videoId);
            $video->update($data);
            session()->flash('notify', 'Vídeo atualizado com sucesso!');
        } else {
            Video::create($data);
            session()->flash('notify', 'Vídeo criado com sucesso!');
        }

        return redirect()->route('admin.videos.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.videos.form');
    }
}
