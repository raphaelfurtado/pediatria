<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload_rejects_non_image_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->postJson(route('admin.upload'), [
                'file' => UploadedFile::fake()->create('shell.php', 100, 'application/x-httpd-php'),
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('file');
    }

    public function test_upload_accepts_image_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->postJson(route('admin.upload'), [
                'file' => UploadedFile::fake()->image('photo.jpg'),
            ])
            ->assertOk()
            ->assertJsonStructure(['url']);
    }

    public function test_guest_cannot_upload(): void
    {
        $this->postJson(route('admin.upload'), [
            'file' => UploadedFile::fake()->image('photo.jpg'),
        ])->assertStatus(401);
    }
}
