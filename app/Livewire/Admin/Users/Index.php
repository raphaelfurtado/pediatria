<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updateRole($userId, $newRole)
    {
        $user = User::findOrFail($userId);

        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return;
        }

        $validRoles = ['admin', 'editor', 'member'];
        if (in_array($newRole, $validRoles)) {
            $user->update(['role' => $newRole]);
            $this->dispatch('notify', 'Função do usuário atualizada com sucesso!');
        }
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            return;
        }

        $user->delete();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users
        ]);
    }
}
