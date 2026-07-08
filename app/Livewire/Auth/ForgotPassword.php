<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email = '';

    public $status = '';

    public function sendLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink(['email' => $this->email]);

        // Mensagem neutra para não revelar quais e-mails existem (anti-enumeração).
        $this->status = 'Se este e-mail estiver cadastrado, enviamos um link para redefinir a senha.';
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('components.layouts.app', ['title' => 'Recuperar senha']);
    }
}
