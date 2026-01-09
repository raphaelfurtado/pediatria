<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        $this->dispatch('notify', 'Evento excluído com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $events = Event::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest('date_start')
            ->paginate(10);

        return view('livewire.admin.events.index', [
            'events' => $events
        ]);
    }
}
