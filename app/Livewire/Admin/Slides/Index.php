<?php

namespace App\Livewire\Admin\Slides;

use App\Models\Slide;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();
        $this->dispatch('notify', 'Slide excluído com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $slides = Slide::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('order')
            ->paginate(10);

        return view('livewire.admin.slides.index', [
            'slides' => $slides
        ]);
    }
}
