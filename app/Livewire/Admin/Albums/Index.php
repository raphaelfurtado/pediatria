<?php

namespace App\Livewire\Admin\Albums;

use App\Models\PhotoAlbum;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $album = PhotoAlbum::findOrFail($id);
        $album->delete();
        $this->dispatch('notify', 'Álbum excluído com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $albums = PhotoAlbum::query()
            ->withCount('photos')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(12);

        return view('livewire.admin.albums.index', [
            'albums' => $albums
        ]);
    }
}
