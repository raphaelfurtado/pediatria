<?php

namespace Tests\Feature;

use App\Livewire\Admin\Pages\Form as PageForm;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_institutional_pages_are_seeded(): void
    {
        foreach (['diretoria', 'estatuto', 'missao', 'departamentos-cientificos'] as $slug) {
            $this->assertDatabaseHas('pages', ['slug' => $slug]);
        }
    }

    public function test_active_page_renders_on_public_route(): void
    {
        $page = Page::create([
            'title' => 'Nossa Diretoria',
            'slug' => 'nossa-diretoria',
            'content' => '<p>Conteúdo institucional.</p>',
            'is_active' => true,
        ]);

        $response = $this->get('/institucional/'.$page->slug);

        $response->assertOk();
        $response->assertSee('Nossa Diretoria');
        $response->assertSee('Conteúdo institucional.', false);
    }

    public function test_inactive_page_returns_404(): void
    {
        $page = Page::create([
            'title' => 'Rascunho',
            'slug' => 'rascunho-institucional',
            'is_active' => false,
        ]);

        $this->get('/institucional/'.$page->slug)->assertNotFound();
    }

    public function test_admin_can_create_a_page(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(PageForm::class)
            ->set('title', 'História da SOPAPE')
            ->set('content', '<p>Fundada em...</p>')
            ->call('save')
            ->assertRedirect(route('admin.pages.index'));

        $this->assertDatabaseHas('pages', [
            'title' => 'História da SOPAPE',
            'slug' => 'historia-da-sopape',
        ]);
    }
}
