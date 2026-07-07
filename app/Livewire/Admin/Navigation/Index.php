<?php

namespace App\Livewire\Admin\Navigation;

use App\Models\MenuItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();
        session()->flash('notify', 'Item de menu excluído com sucesso!');
    }

    public function toggleStatus($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->is_active = ! $item->is_active;
        $item->save();
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
     * Swap a menu item with its previous/next sibling and normalise ordering.
     */
    protected function move($id, int $direction): void
    {
        $item = MenuItem::findOrFail($id);

        $ids = MenuItem::where('parent_id', $item->parent_id)
            ->orderBy('order')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        $pos = array_search($item->id, $ids, true);
        $target = $pos + $direction;

        if ($pos === false || $target < 0 || $target >= count($ids)) {
            return;
        }

        [$ids[$pos], $ids[$target]] = [$ids[$target], $ids[$pos]];

        foreach ($ids as $index => $mid) {
            MenuItem::where('id', $mid)->update(['order' => $index]);
        }

        session()->flash('notify', 'Ordem do menu atualizada.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $menuItems = MenuItem::topLevel()->with('children')->orderBy('order')->get();

        return view('livewire.admin.navigation.index', [
            'menuItems' => $menuItems,
        ]);
    }
}
