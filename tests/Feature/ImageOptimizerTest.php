<?php

namespace Tests\Feature;

use App\Livewire\Admin\Posts\Form as PostForm;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageOptimizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class ImageOptimizerTest extends TestCase
{
    use RefreshDatabase;

    public function test_large_image_is_downscaled_and_converted_to_webp(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('foto-grande.jpg', 3000, 2000);

        $path = ImageOptimizer::store($file, 'posts');

        $this->assertTrue(Str::endsWith($path, '.webp'));
        Storage::disk('public')->assertExists($path);

        // Largura reduzida para o teto (1600) e ainda uma imagem válida.
        $bytes = Storage::disk('public')->get($path);
        $image = imagecreatefromstring($bytes);
        $this->assertNotFalse($image);
        $this->assertLessThanOrEqual(1600, imagesx($image));
    }

    public function test_optimized_file_is_smaller_than_original(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('foto.jpg', 2500, 1600);
        $originalSize = $file->getSize();

        $path = ImageOptimizer::store($file, 'posts');

        $this->assertLessThan($originalSize, Storage::disk('public')->size($path));
    }

    public function test_non_image_is_stored_untouched(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('documento.pdf', 200, 'application/pdf');

        $path = ImageOptimizer::store($file, 'docs');

        $this->assertTrue(Str::endsWith($path, '.pdf'));
        Storage::disk('public')->assertExists($path);
    }

    public function test_post_featured_image_is_optimized_to_webp(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(PostForm::class)
            ->set('title', 'Notícia com imagem')
            ->set('slug', 'noticia-com-imagem')
            ->set('content', 'Conteúdo da notícia.')
            ->set('category', 'Notícias')
            ->set('status', 'draft')
            ->set('image', UploadedFile::fake()->image('capa.jpg', 2400, 1600))
            ->call('save');

        $post = Post::firstOrFail();
        $this->assertTrue(Str::endsWith($post->image_path, '.webp'));
    }
}
