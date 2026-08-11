<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public function delete($id): void
    {
        Page::findOrFail($id)->delete();
        $this->dispatch('notify', 'Página excluída com sucesso!');
    }

    public function toggleStatus($id): void
    {
        $page = Page::findOrFail($id);
        $page->is_active = ! $page->is_active;
        $page->save();
        $this->dispatch('notify', 'Status da página atualizado.');
    }

    public function moveUp($id): void
    {
        $this->move($id, -1);
    }

    public function moveDown($id): void
    {
        $this->move($id, 1);
    }

    protected function move($id, int $direction): void
    {
        $ids = Page::orderBy('order')->orderBy('id')->pluck('id')->all();

        $pos = array_search((int) $id, $ids, true);
        $target = $pos + $direction;

        if ($pos === false || $target < 0 || $target >= count($ids)) {
            return;
        }

        [$ids[$pos], $ids[$target]] = [$ids[$target], $ids[$pos]];

        foreach ($ids as $index => $pid) {
            Page::where('id', $pid)->update(['order' => $index]);
        }

        $this->dispatch('notify', 'Ordem das páginas atualizada.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.pages.index', [
            'pages' => Page::orderBy('order')->orderBy('id')->get(),
        ]);
    }
}
