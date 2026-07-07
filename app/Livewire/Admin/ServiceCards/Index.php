<?php

namespace App\Livewire\Admin\ServiceCards;

use App\Models\ServiceCard;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        ServiceCard::findOrFail($id)->delete();
        $this->dispatch('notify', 'Card excluído com sucesso!');
    }

    public function toggleStatus($id)
    {
        $card = ServiceCard::findOrFail($id);
        $card->update(['is_active' => ! $card->is_active]);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $cards = ServiceCard::query()
            ->where('title', 'like', '%'.$this->search.'%')
            ->orderBy('order')
            ->paginate(10);

        return view('livewire.admin.service-cards.index', [
            'cards' => $cards,
        ]);
    }
}
