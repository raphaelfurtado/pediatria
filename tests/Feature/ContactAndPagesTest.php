<?php

namespace Tests\Feature;

use App\Livewire\Contact\Form as ContactForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactAndPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_legal_and_contact_pages_load(): void
    {
        $this->get('/politica-de-privacidade')->assertOk();
        $this->get('/termos-de-uso')->assertOk();
        $this->get('/contato')->assertOk();
    }

    public function test_forgot_password_page_loads(): void
    {
        $this->get('/esqueci-senha')->assertOk();
    }

    public function test_register_route_is_removed(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_contact_form_saves_message(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Fulano de Tal')
            ->set('email', 'fulano@example.com')
            ->set('subject', 'Dúvida')
            ->set('message', 'Olá, tenho uma dúvida sobre a associação.')
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'fulano@example.com',
            'is_read' => false,
        ]);
    }

    public function test_contact_form_requires_message(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Fulano')
            ->set('email', 'fulano@example.com')
            ->set('message', '')
            ->call('submit')
            ->assertHasErrors('message');
    }
}
