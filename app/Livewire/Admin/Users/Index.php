<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updateRole($userId, $newRole)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $user = User::findOrFail($userId);

        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return;
        }

        if (! in_array($newRole, UserRole::values(), true)) {
            $this->dispatch('notify', 'Função inválida.');

            return;
        }

        $user->update(['role' => $newRole]);
        $this->dispatch('notify', 'Função do usuário atualizada com sucesso!');
    }

    public function delete($userId)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            return;
        }

        // Authors are referenced by posts (FK restrict) — block instead of 500.
        if (Post::where('author_id', $user->id)->exists()) {
            $this->dispatch('notify', 'Não é possível excluir: o usuário possui notícias. Reatribua ou exclua as notícias antes.');

            return;
        }

        $user->delete();
        $this->dispatch('notify', 'Usuário excluído com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $users = User::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ]);
    }
}
