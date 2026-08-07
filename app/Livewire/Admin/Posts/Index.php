<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public bool $trashed = false;

    public array $selected = [];

    public bool $selectAll = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->clearSelection();
    }

    public function setTrashed(bool $value): void
    {
        if ($this->trashed === $value) {
            return;
        }

        $this->trashed = $value;
        $this->resetPage();
        $this->clearSelection();
    }

    public function updatedSelectAll($value): void
    {
        $this->selected = $value
            ? $this->baseQuery()->paginate(10)->pluck('id')->map(fn ($id) => (string) $id)->all()
            : [];
    }

    protected function clearSelection(): void
    {
        $this->reset('selected', 'selectAll');
    }

    protected function baseQuery(): Builder
    {
        return Post::query()
            ->when($this->trashed, fn ($q) => $q->onlyTrashed())
            ->with('author')
            ->where('title', 'like', '%'.$this->search.'%')
            ->latest($this->trashed ? 'deleted_at' : 'published_at');
    }

    // --- Ações individuais -------------------------------------------------

    public function delete($id): void
    {
        Post::findOrFail($id)->delete();
        $this->afterAction('Notícia movida para a lixeira.');
    }

    public function restore($id): void
    {
        Post::onlyTrashed()->findOrFail($id)->restore();
        $this->afterAction('Notícia restaurada.');
    }

    public function forceDeleteRow($id): void
    {
        Post::onlyTrashed()->findOrFail($id)->forceDelete();
        $this->afterAction('Notícia excluída definitivamente.');
    }

    // --- Ações em lote -----------------------------------------------------

    public function deleteSelected(): void
    {
        Post::whereIn('id', $this->selected)->delete();
        $this->afterAction('Notícias movidas para a lixeira.');
    }

    public function restoreSelected(): void
    {
        Post::onlyTrashed()->whereIn('id', $this->selected)->restore();
        $this->afterAction('Notícias restauradas.');
    }

    public function forceDeleteSelected(): void
    {
        Post::onlyTrashed()->whereIn('id', $this->selected)->forceDelete();
        $this->afterAction('Notícias excluídas definitivamente.');
    }

    protected function afterAction(string $message): void
    {
        $this->clearSelection();
        $this->dispatch('notify', $message);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.posts.index', [
            'posts' => $this->baseQuery()->paginate(10),
            'trashedCount' => Post::onlyTrashed()->count(),
        ]);
    }
}
