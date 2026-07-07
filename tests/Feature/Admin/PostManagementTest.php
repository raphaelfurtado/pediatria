<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Posts\Form as PostForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_editor_can_create_a_post(): void
    {
        $editor = User::factory()->editor()->create();

        $this->actingAs($editor);

        Livewire::test(PostForm::class)
            ->set('title', 'Nova Notícia de Teste')
            ->set('slug', 'nova-noticia-de-teste')
            ->set('content', '<p>Conteúdo da notícia.</p>')
            ->set('category', 'Notícias')
            ->set('status', 'draft')
            ->call('save')
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', [
            'slug' => 'nova-noticia-de-teste',
            'author_id' => $editor->id,
        ]);
    }

    public function test_post_creation_requires_a_title(): void
    {
        $editor = User::factory()->editor()->create();

        $this->actingAs($editor);

        Livewire::test(PostForm::class)
            ->set('title', '')
            ->set('slug', 'sem-titulo')
            ->set('content', 'x')
            ->set('category', 'Notícias')
            ->call('save')
            ->assertHasErrors('title');
    }
}
