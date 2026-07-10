<?php

namespace Tests\Feature;

use App\Livewire\Profile\Edit as ProfileEdit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_own_name_and_email(): void
    {
        $user = User::factory()->editor()->create();
        $this->actingAs($user);

        Livewire::test(ProfileEdit::class)
            ->set('name', 'Novo Nome')
            ->set('email', 'novo@example.com')
            ->call('updateProfile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Novo Nome',
            'email' => 'novo@example.com',
        ]);
    }

    public function test_user_can_change_own_password(): void
    {
        $user = User::factory()->create(); // senha padrão 'password'
        $this->actingAs($user);

        Livewire::test(ProfileEdit::class)
            ->set('current_password', 'password')
            ->set('password', 'novaSenha123')
            ->set('password_confirmation', 'novaSenha123')
            ->call('updatePassword');

        $this->assertTrue(Hash::check('novaSenha123', $user->fresh()->password));
    }

    public function test_password_change_requires_correct_current_password(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(ProfileEdit::class)
            ->set('current_password', 'senha-errada')
            ->set('password', 'novaSenha123')
            ->set('password_confirmation', 'novaSenha123')
            ->call('updatePassword')
            ->assertHasErrors('current_password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_profile_requires_authentication(): void
    {
        $this->get('/admin/perfil')->assertRedirect(route('login'));
    }
}
