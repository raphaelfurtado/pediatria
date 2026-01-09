<?php

namespace App\Livewire\Admin\Navigation;

use App\Models\MenuItem;
use Livewire\Component;
use Livewire\Attributes\Layout;

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
        $item->is_active = !$item->is_active;
        $item->save();
    }

    public function reorder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            MenuItem::where('id', $id)->update(['order' => $index]);
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $menuItems = MenuItem::topLevel()->with('children')->orderBy('order')->get();

        return view('livewire.admin.navigation.index', [
            'menuItems' => $menuItems
        ]);
    }
}
