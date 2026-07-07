<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\Form as SettingsForm;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_configured_contact(): void
    {
        SiteSetting::set('contact_email', 'novo@sopape.com');
        SiteSetting::set('contact_phone', '(91) 3222-1111');

        $this->get('/')
            ->assertOk()
            ->assertSee('novo@sopape.com')
            ->assertSee('(91) 3222-1111');
    }

    public function test_admin_can_save_contact_settings(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        Livewire::test(SettingsForm::class)
            ->set('contact_email', 'contato@teste.com')
            ->set('contact_phone', '(11) 4000-0000')
            ->call('save');

        $this->assertSame('contato@teste.com', SiteSetting::get('contact_email'));
        $this->assertSame('(11) 4000-0000', SiteSetting::get('contact_phone'));
    }
}
