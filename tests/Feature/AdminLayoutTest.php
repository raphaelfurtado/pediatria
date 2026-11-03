<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_footer_shows_php_version(): void
    {
        $this->actingAs(User::factory()->editor()->create())
            ->get(route('admin.slides.index'))
            ->assertOk()
            ->assertSee('PHP '.PHP_VERSION);
    }
}
