<?php

namespace App\Livewire\Admin\ServiceCards;

use App\Models\ServiceCard;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public $cardId;

    public $title;

    public $description;

    public $icon = 'star';

    public $color = 'primary';

    public $link = '#';

    public $cta_text = 'Saiba mais';

    public $order = 0;

    public $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $card = ServiceCard::findOrFail($id);
            $this->cardId = $card->id;
            $this->title = $card->title;
            $this->description = $card->description;
            $this->icon = $card->icon;
            $this->color = $card->color;
            $this->link = $card->link;
            $this->cta_text = $card->cta_text;
            $this->order = $card->order;
            $this->is_active = (bool) $card->is_active;
        }
    }

    public function save()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'required|string|max:50',
            'color' => ['required', Rule::in(ServiceCard::COLORS)],
            'link' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string|max:50',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        if ($this->cardId) {
            ServiceCard::findOrFail($this->cardId)->update($data);
            session()->flash('notify', 'Card atualizado com sucesso!');
        } else {
            ServiceCard::create($data);
            session()->flash('notify', 'Card criado com sucesso!');
        }

        return redirect()->route('admin.service-cards.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.service-cards.form', [
            'colors' => ServiceCard::COLORS,
        ]);
    }
}
