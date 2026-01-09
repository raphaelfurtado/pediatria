<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Video;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        $this->dispatch('notify', 'Vídeo excluído com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $videos = Video::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(12);

        return view('livewire.admin.videos.index', [
            'videos' => $videos
        ]);
    }
}
