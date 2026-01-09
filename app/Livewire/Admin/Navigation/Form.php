<?php

namespace App\Livewire\Admin\Navigation;

use App\Models\MenuItem;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Form extends Component
{
    public $itemId;
    public $label;
    public $url;
    public $parent_id;
    public $order = 0;
    public $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $item = MenuItem::findOrFail($id);
            $this->itemId = $item->id;
            $this->label = $item->label;
            $this->url = $item->url;
            $this->parent_id = $item->parent_id;
            $this->order = $item->order;
            $this->is_active = $item->is_active;
        }
    }

    public function save()
    {
        $this->validate([
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'label' => $this->label,
            'url' => $this->url,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->itemId) {
            MenuItem::find($this->itemId)->update($data);
            session()->flash('notify', 'Item de menu atualizado com sucesso!');
        } else {
            MenuItem::create($data);
            session()->flash('notify', 'Item de menu criado com sucesso!');
        }

        return redirect()->route('admin.navigation.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $parentItems = MenuItem::topLevel()
            ->when($this->itemId, fn($q) => $q->where('id', '!=', $this->itemId))
            ->get();

        return view('livewire.admin.navigation.form', [
            'parentItems' => $parentItems
        ]);
    }
}
