<?php

namespace App\Livewire\Admin\Messages;

use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected const PER_PAGE = 15;

    /** IDs marcados para exclusão em lote. */
    public array $selected = [];

    public function togglePageSelection()
    {
        $pageIds = $this->pageIds();

        $this->selected = array_diff($pageIds, $this->selected)
            ? array_values(array_unique([...$this->selected, ...$pageIds]))
            : array_values(array_diff($this->selected, $pageIds));
    }

    protected function pageIds(): array
    {
        return ContactMessage::latest()->forPage($this->getPage(), self::PER_PAGE)
            ->pluck('id')->map(fn ($id) => (string) $id)->all();
    }

    public function deleteSelected()
    {
        $count = ContactMessage::whereIn('id', $this->selected)->delete();
        $this->selected = [];

        $this->dispatch('notify', $count === 1 ? '1 mensagem excluída.' : "{$count} mensagens excluídas.");
    }

    public function toggleRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => ! $message->is_read]);
    }

    public function delete($id)
    {
        ContactMessage::findOrFail($id)->delete();
        $this->selected = array_values(array_diff($this->selected, [(string) $id]));
        $this->dispatch('notify', 'Mensagem excluída.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        // Mantém a seleção só com mensagens que ainda existem, para a contagem do botão bater.
        if ($this->selected) {
            $this->selected = ContactMessage::whereIn('id', $this->selected)
                ->pluck('id')->map(fn ($id) => (string) $id)->values()->all();
        }

        $messages = ContactMessage::latest()->paginate(self::PER_PAGE);
        $pageIds = $messages->pluck('id')->map(fn ($id) => (string) $id)->all();

        return view('livewire.admin.messages.index', [
            'messages' => $messages,
            'pageAllSelected' => $pageIds && ! array_diff($pageIds, $this->selected),
        ]);
    }
}
