<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\Form as SettingsForm;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddressMapSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_configured_address_appears_in_footer(): void
    {
        SiteSetting::set('contact_address', "Avenida Nazaré, 100\nBelém - PA");

        $this->get('/')->assertSee('Avenida Nazaré, 100', false);
    }

    public function test_map_iframe_is_shown_when_configured(): void
    {
        SiteSetting::set('map_embed_url', 'https://www.google.com/maps/embed?pb=ABC123');

        $response = $this->get('/');

        $response->assertSee('<iframe', false);
        $response->assertSee('https://www.google.com/maps/embed?pb=ABC123', false);
    }

    public function test_admin_can_save_address_and_map(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(SettingsForm::class)
            ->set('contact_address', "Rua Nova, 50\nBelém")
            ->set('map_embed_url', '<iframe src="https://www.google.com/maps/embed?pb=XYZ" loading="lazy"></iframe>')
            ->call('save');

        $this->assertSame("Rua Nova, 50\nBelém", SiteSetting::get('contact_address'));
        // Extrai o src de dentro do <iframe>.
        $this->assertSame('https://www.google.com/maps/embed?pb=XYZ', SiteSetting::get('map_embed_url'));
    }

    public function test_map_rejects_non_google_urls(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(SettingsForm::class)
            ->set('map_embed_url', 'https://sitemalicioso.com/iframe')
            ->call('save');

        $this->assertNull(SiteSetting::get('map_embed_url'));
    }
}
