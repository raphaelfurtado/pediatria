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
        $form = Livewire::test(ContactForm::class)
            ->set('name', 'Fulano de Tal')
            ->set('email', 'fulano@example.com')
            ->set('subject', 'Dúvida')
            ->set('message', 'Olá, tenho uma dúvida sobre a associação.');

        $this->travel(10)->seconds();

        $form->call('submit')->assertSet('sent', true);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'fulano@example.com',
            'is_read' => false,
        ]);
    }

    public function test_contact_form_discards_bot_filling_honeypot(): void
    {
        $form = Livewire::test(ContactForm::class)
            ->set('name', 'vHhUfYxeeRKGUBjJXDCLp')
            ->set('email', 'iq.a.x.eso.43.7@gmail.com')
            ->set('message', 'cxrAsOmvvDQqAeUC')
            ->set('website', 'http://spam.example');

        $this->travel(10)->seconds();

        $form->call('submit')->assertSet('sent', true);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_discards_submission_faster_than_a_human(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Robô Apressado')
            ->set('email', 'robo@example.com')
            ->set('message', 'Enviado no mesmo segundo em que a página abriu.')
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_start_time_cannot_be_tampered(): void
    {
        $this->expectException(\Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException::class);

        Livewire::test(ContactForm::class)->set('startedAt', 0);
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
