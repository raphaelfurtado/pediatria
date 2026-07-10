<?php

namespace App\Livewire\Profile;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public $name = '';

    public $email = '';

    public $current_password = '';

    public $password = '';

    public $password_confirmation = '';

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ], [
            'name.required' => 'Informe seu nome.',
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'E-mail inválido.',
            'email.unique' => 'Este e-mail já está em uso.',
        ]);

        $user->update($data);

        $this->dispatch('notify', 'Dados atualizados com sucesso!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Informe sua senha atual.',
            'current_password.current_password' => 'A senha atual está incorreta.',
            'password.required' => 'Informe a nova senha.',
            'password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        // O cast 'hashed' no model User faz o hash automaticamente ao salvar.
        auth()->user()->update(['password' => $this->password]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('notify', 'Senha alterada com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.profile.edit');
    }
}
