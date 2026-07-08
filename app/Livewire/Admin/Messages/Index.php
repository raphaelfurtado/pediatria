<?php

namespace App\Livewire\Admin\Messages;

use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function toggleRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => ! $message->is_read]);
    }

    public function delete($id)
    {
        ContactMessage::findOrFail($id)->delete();
        $this->dispatch('notify', 'Mensagem excluída.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.messages.index', [
            'messages' => ContactMessage::latest()->paginate(15),
        ]);
    }
}
