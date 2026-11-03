<?php

namespace App\Livewire\Contact;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Form extends Component
{
    /** Envio mais rápido que isso (desde a abertura da página) é tratado como robô. */
    public const MIN_SECONDS_TO_SUBMIT = 3;

    public $name = '';

    public $email = '';

    public $subject = '';

    public $message = '';

    public $sent = false;

    /** Campo-isca: escondido de pessoas, mas robôs costumam preenchê-lo. */
    public $website = '';

    #[Locked]
    public $startedAt;

    public function mount()
    {
        $this->startedAt = now()->timestamp;
    }

    public function submit()
    {
        $key = 'contact:'.Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('message', 'Muitas mensagens em pouco tempo. Aguarde um instante e tente novamente.');

            return;
        }

        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        RateLimiter::hit($key, 60);

        // Robô: finge que enviou (para não ensinar o bot a contornar) e descarta.
        if ($this->looksLikeBot()) {
            $this->reset(['name', 'email', 'subject', 'message', 'website']);
            $this->sent = true;

            return;
        }

        $contact = ContactMessage::create($data);

        // Aviso por e-mail (best-effort): se o SMTP não estiver configurado, a mensagem
        // continua salva no painel (Admin -> Mensagens), então nada se perde.
        try {
            $to = SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com');

            Mail::raw(
                "Nova mensagem de contato pelo site:\n\n".
                "Nome: {$contact->name}\n".
                "E-mail: {$contact->email}\n".
                "Assunto: {$contact->subject}\n\n".
                "{$contact->message}",
                function ($mail) use ($to, $contact) {
                    $mail->to($to)
                        ->replyTo($contact->email, $contact->name)
                        ->subject('Contato pelo site: '.($contact->subject ?: 'Sem assunto'));
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->sent = true;
    }

    protected function looksLikeBot(): bool
    {
        return filled($this->website)
            || now()->timestamp - (int) $this->startedAt < self::MIN_SECONDS_TO_SUBMIT;
    }

    public function render()
    {
        return view('livewire.contact.form')
            ->layout('components.layouts.app', ['title' => 'Contato']);
    }
}
