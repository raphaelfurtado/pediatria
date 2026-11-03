<?php

namespace Tests\Feature;

use App\Livewire\Admin\Albums\Form as AlbumForm;
use App\Livewire\Admin\Events\Form as EventForm;
use App\Livewire\Admin\Posts\Form as PostForm;
use App\Livewire\Admin\Publications\Form as PublicationForm;
use App\Livewire\Admin\Slides\Form as SlideForm;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SlideFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs(User::factory()->editor()->create());
    }

    public function test_editor_can_create_a_slide_with_jpg(): void
    {
        Livewire::test(SlideForm::class)
            ->set('title', 'Banner da Home')
            ->set('image', UploadedFile::fake()->image('foto.jpg', 2000, 1000))
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.slides.index'));

        $this->assertSame('Banner da Home', Slide::first()->title);
    }

    public function test_heic_upload_shows_warning_instead_of_crashing(): void
    {
        Livewire::test(SlideForm::class)
            ->set('title', 'Banner da Home')
            ->set('image', UploadedFile::fake()->create('foto.heic', 900, 'image/heic'))
            ->assertSee('Formato não suportado')
            ->call('save')
            ->assertHasErrors(['image']);

        $this->assertSame(0, Slide::count());
    }

    public function test_other_admin_forms_do_not_crash_on_heic_upload(): void
    {
        $heic = fn () => UploadedFile::fake()->create('foto.heic', 900, 'image/heic');

        Livewire::test(PostForm::class)->set('image', $heic())->assertSee('Formato não suportado');
        Livewire::test(EventForm::class)->set('image', $heic())->assertSee('Formato não suportado');
        Livewire::test(PublicationForm::class)->set('cover', $heic())->assertSee('Formato não suportado');
        Livewire::test(AlbumForm::class)->set('cover', $heic())->assertSee('Formato não suportado');
        Livewire::test(AlbumForm::class)->set('photos', [$heic()])->assertSee('Formato não suportado');
    }
}
