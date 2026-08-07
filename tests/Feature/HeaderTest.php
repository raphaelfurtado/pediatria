<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_email_and_phone_are_clickable_links(): void
    {
        SiteSetting::set('contact_email', 'contato@sopape.org.br');
        SiteSetting::set('contact_phone', '(91) 98293-0137');

        $response = $this->get('/');

        $response->assertSee('mailto:contato@sopape.org.br', false);
        $response->assertSee('tel:+5591982930137', false);
    }

    public function test_header_has_a_working_search_form(): void
    {
        $response = $this->get('/');

        $response->assertSee('action="'.route('posts.index').'"', false);
        $response->assertSee('name="search"', false);
    }

    public function test_news_search_filters_results(): void
    {
        Post::factory()->create([
            'title' => 'Campanha de Vacinacao 2026',
            'slug' => 'vacina-2026',
            'published_at' => now()->subDay(),
        ]);
        Post::factory()->create([
            'title' => 'Congresso de Pediatria',
            'slug' => 'congresso',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('posts.index', ['search' => 'Vacinacao']));

        $response->assertOk();
        $response->assertSee('Campanha de Vacinacao 2026');
        $response->assertDontSee('Congresso de Pediatria');
    }
}
