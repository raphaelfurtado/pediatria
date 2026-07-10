<?php

namespace App\Livewire\Admin\Activities;

use App\Models\ActivityLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $event = '';

    public function updating($property): void
    {
        if (in_array($property, ['search', 'event'])) {
            $this->resetPage();
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $logs = ActivityLog::query()
            ->when($this->search !== '', fn ($q) => $q->where(function ($q) {
                $q->where('description', 'like', '%'.$this->search.'%')
                    ->orWhere('user_name', 'like', '%'.$this->search.'%');
            }))
            ->when($this->event !== '', fn ($q) => $q->where('event', $this->event))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.activities.index', [
            'logs' => $logs,
        ]);
    }
}
