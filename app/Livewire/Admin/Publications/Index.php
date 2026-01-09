<?php

namespace App\Livewire\Admin\Publications;

use App\Models\Publication;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $publication = Publication::findOrFail($id);
        $publication->delete();
        $this->dispatch('notify', 'Publicação excluída com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $publications = Publication::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.publications.index', [
            'publications' => $publications
        ]);
    }
}
