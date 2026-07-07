<?php

namespace Tests\Feature;

use App\Livewire\Admin\ServiceCards\Form as CardForm;
use App\Models\ServiceCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_card_appears_on_home(): void
    {
        ServiceCard::factory()->create([
            'title' => 'CARD ATIVO NA HOME',
            'is_active' => true,
        ]);

        $this->get('/')->assertOk()->assertSee('CARD ATIVO NA HOME');
    }

    public function test_inactive_card_is_not_on_home(): void
    {
        ServiceCard::factory()->create([
            'title' => 'CARD INATIVO NA HOME',
            'is_active' => false,
        ]);

        $this->get('/')->assertDontSee('CARD INATIVO NA HOME');
    }

    public function test_editor_can_create_a_card(): void
    {
        $editor = User::factory()->editor()->create();
        $this->actingAs($editor);

        Livewire::test(CardForm::class)
            ->set('title', 'Novo Card de Teste')
            ->set('description', 'Descrição do card')
            ->set('icon', 'star')
            ->set('color', 'primary')
            ->set('link', '/teste')
            ->set('cta_text', 'Ir')
            ->set('order', 1)
            ->call('save')
            ->assertRedirect(route('admin.service-cards.index'));

        $this->assertDatabaseHas('service_cards', ['title' => 'Novo Card de Teste']);
    }

    public function test_invalid_color_is_rejected(): void
    {
        $editor = User::factory()->editor()->create();
        $this->actingAs($editor);

        Livewire::test(CardForm::class)
            ->set('title', 'Card X')
            ->set('icon', 'star')
            ->set('color', 'purple')
            ->set('order', 0)
            ->call('save')
            ->assertHasErrors('color');
    }

    public function test_guest_cannot_access_cards_admin(): void
    {
        $this->get('/admin/cards')->assertRedirect(route('login'));
    }
}
