<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBarTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_sees_admin_bar_with_edit_link_on_post(): void
    {
        $editor = User::factory()->create(['role' => 'editor', 'name' => 'Maria Editora']);
        $post = Post::factory()->create([
            'slug' => 'post-editavel',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->actingAs($editor)->get('/noticias/'.$post->slug);

        $response->assertSee(route('admin.posts.edit', $post->id), false);
        $response->assertSee(route('admin.dashboard'), false);
        $response->assertSee('Maria Editora');
    }

    public function test_guest_does_not_see_admin_bar(): void
    {
        $post = Post::factory()->create([
            'slug' => 'post-publico',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/noticias/'.$post->slug)
            ->assertDontSee(route('admin.dashboard'), false);
    }

    public function test_non_staff_member_does_not_see_admin_bar(): void
    {
        $socio = User::factory()->create(['role' => 'socio']);
        $post = Post::factory()->create([
            'slug' => 'post-socio',
            'published_at' => now()->subDay(),
        ]);

        $this->actingAs($socio)->get('/noticias/'.$post->slug)
            ->assertDontSee(route('admin.dashboard'), false);
    }
}
