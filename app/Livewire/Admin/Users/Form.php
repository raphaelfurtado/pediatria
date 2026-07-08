<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public $userId;

    public $name = '';

    public $email = '';

    public $password = '';

    public $role = 'editor';

    public $is_active = true;

    public function mount($id = null)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->is_active = (bool) $user->is_active;
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->userId)],
            'role' => ['required', Rule::in(UserRole::values())],
            'is_active' => 'boolean',
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'is_active' => $data['is_active'],
        ];

        // The User model casts `password` as `hashed`, so a plain value is hashed on save.
        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        if ($this->userId) {
            User::findOrFail($this->userId)->update($payload);
            session()->flash('notify', 'Usuário atualizado com sucesso!');
        } else {
            User::create($payload);
            session()->flash('notify', 'Usuário criado com sucesso!');
        }

        return redirect()->route('admin.users.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.users.form', [
            'roles' => UserRole::cases(),
        ]);
    }
}
