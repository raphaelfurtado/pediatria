<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteExtrasTest extends TestCase
{
    use RefreshDatabase;

    // --- WhatsApp flutuante -------------------------------------------------

    public function test_whatsapp_button_appears_when_number_is_configured(): void
    {
        SiteSetting::set('whatsapp', '5591988887777');

        $response = $this->get('/');

        $response->assertSee('https://wa.me/5591988887777', false);
        $response->assertSee('Falar no WhatsApp', false);
    }

    public function test_whatsapp_button_hidden_when_not_configured(): void
    {
        $this->get('/')->assertDontSee('Falar no WhatsApp');
    }

    public function test_whatsapp_number_gets_brazil_country_code_when_missing(): void
    {
        SiteSetting::set('whatsapp', '(91) 98293-0137');

        $this->get('/')->assertSee('https://wa.me/5591982930137', false);
    }

    // --- Compartilhamento nas notícias -------------------------------------

    public function test_post_has_share_buttons(): void
    {
        $post = Post::factory()->create([
            'slug' => 'noticia-compartilhavel',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/noticias/'.$post->slug);

        $response->assertSee('api.whatsapp.com/send', false);
        $response->assertSee('facebook.com/sharer', false);
        $response->assertSee('Copiar link');
    }

    // --- Acessibilidade -----------------------------------------------------

    public function test_accessibility_features_are_present(): void
    {
        $response = $this->get('/');

        $response->assertSee('Pular para o conteúdo');
        $response->assertSee('id="main"', false);
        $response->assertSee('vlibras.gov.br/app/vlibras-plugin.js', false);
        $response->assertSee('Acessibilidade', false);
    }
}
