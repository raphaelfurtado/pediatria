<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_visitante_cannot_access_admin(): void
    {
        $user = User::factory()->create(); // visitante by default

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_editor_can_access_dashboard(): void
    {
        $editor = User::factory()->editor()->create();

        $this->actingAs($editor)->get('/admin')->assertOk();
    }

    public function test_editor_cannot_access_users_admin(): void
    {
        $editor = User::factory()->editor()->create();

        $this->actingAs($editor)->get('/admin/users')->assertForbidden();
    }

    public function test_admin_can_access_users_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin/users')->assertOk();
    }

    public function test_deactivated_admin_loses_access(): void
    {
        $admin = User::factory()->admin()->inactive()->create();

        $this->actingAs($admin)->get('/admin')->assertRedirect(route('login'));
    }
}
