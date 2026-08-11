<?php

namespace App\Livewire\Admin\Publications;

use App\Models\Publication;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

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

    public function moveUp($id)
    {
        $this->move($id, -1);
    }

    public function moveDown($id)
    {
        $this->move($id, 1);
    }

    /**
     * Troca a publicação com a vizinha (acima/abaixo) e normaliza a ordenação.
     */
    protected function move($id, int $direction): void
    {
        $ids = Publication::orderBy('order')->orderBy('id')->pluck('id')->all();

        $pos = array_search((int) $id, $ids, true);
        $target = $pos + $direction;

        if ($pos === false || $target < 0 || $target >= count($ids)) {
            return;
        }

        [$ids[$pos], $ids[$target]] = [$ids[$target], $ids[$pos]];

        foreach ($ids as $index => $pid) {
            Publication::where('id', $pid)->update(['order' => $index]);
        }

        $this->dispatch('notify', 'Ordem das publicações atualizada.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $publications = Publication::query()
            ->where('title', 'like', '%'.$this->search.'%')
            ->orderBy('order')
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.admin.publications.index', [
            'publications' => $publications,
        ]);
    }
}
