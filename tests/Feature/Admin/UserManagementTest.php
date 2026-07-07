<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_change_a_user_role(): void
    {
        $admin = User::factory()->admin()->create();
        $target = User::factory()->create(); // visitante

        $this->actingAs($admin);

        Livewire::test(UsersIndex::class)
            ->call('updateRole', $target->id, 'editor');

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'role' => 'editor',
        ]);
    }

    public function test_invalid_role_is_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $target = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(UsersIndex::class)
            ->call('updateRole', $target->id, 'superuser');

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'role' => 'visitante',
        ]);
    }

    public function test_non_admin_cannot_change_roles(): void
    {
        $editor = User::factory()->editor()->create();
        $target = User::factory()->create();

        $this->actingAs($editor);

        Livewire::test(UsersIndex::class)
            ->call('updateRole', $target->id, 'admin')
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'role' => 'visitante',
        ]);
    }

    public function test_cannot_delete_user_who_has_posts(): void
    {
        $admin = User::factory()->admin()->create();
        $author = User::factory()->editor()->create();
        Post::factory()->create(['author_id' => $author->id]);

        $this->actingAs($admin);

        Livewire::test(UsersIndex::class)
            ->call('delete', $author->id);

        $this->assertDatabaseHas('users', ['id' => $author->id]);
    }

    public function test_can_delete_user_without_posts(): void
    {
        $admin = User::factory()->admin()->create();
        $target = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(UsersIndex::class)
            ->call('delete', $target->id);

        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }
}
