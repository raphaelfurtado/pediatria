<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MemberController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/noticias', [PostController::class, 'index'])->name('posts.index');
Route::get('/noticias/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/biblioteca', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/biblioteca/{slug}', [PublicationController::class, 'show'])->name('publications.show');
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
Route::get('/galeria', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeria/{id}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/sobre', [App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
// Route::get('/contato', [App\Http\Controllers\PageController::class, 'contact'])->name('pages.contact');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/area-do-socio', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::post('/logout', [MemberController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index')->middleware('role:admin');
    Route::get('/posts', \App\Livewire\Admin\Posts\Index::class)->name('posts.index');
    Route::get('/posts/create', \App\Livewire\Admin\Posts\Form::class)->name('posts.create');
    Route::get('/posts/{id}/edit', \App\Livewire\Admin\Posts\Form::class)->name('posts.edit');
    Route::post('/upload', [\App\Http\Controllers\Admin\UploadController::class, 'store'])->name('upload');
    Route::get('/slides', \App\Livewire\Admin\Slides\Index::class)->name('slides.index');
    Route::get('/slides/create', \App\Livewire\Admin\Slides\Form::class)->name('slides.create');
    Route::get('/slides/{id}/edit', \App\Livewire\Admin\Slides\Form::class)->name('slides.edit');

    Route::get('/events', \App\Livewire\Admin\Events\Index::class)->name('events.index');
    Route::get('/events/create', \App\Livewire\Admin\Events\Form::class)->name('events.create');
    Route::get('/events/{id}/edit', \App\Livewire\Admin\Events\Form::class)->name('events.edit');

    Route::get('/publications', \App\Livewire\Admin\Publications\Index::class)->name('publications.index');
    Route::get('/publications/create', \App\Livewire\Admin\Publications\Form::class)->name('publications.create');
    Route::get('/publications/{id}/edit', \App\Livewire\Admin\Publications\Form::class)->name('publications.edit');

    Route::get('/albums', \App\Livewire\Admin\Albums\Index::class)->name('albums.index');
    Route::get('/albums/create', \App\Livewire\Admin\Albums\Form::class)->name('albums.create');
    Route::get('/albums/{id}/edit', \App\Livewire\Admin\Albums\Form::class)->name('albums.edit');

    Route::get('/videos', \App\Livewire\Admin\Videos\Index::class)->name('videos.index');
    Route::get('/videos/create', \App\Livewire\Admin\Videos\Form::class)->name('videos.create');
    Route::get('/videos/{id}/edit', \App\Livewire\Admin\Videos\Form::class)->name('videos.edit');
    Route::get('/settings', App\Livewire\Admin\Settings\Form::class)->name('settings');

    Route::get('/navegacao', \App\Livewire\Admin\Navigation\Index::class)->name('navigation.index');
    Route::get('/navegacao/novo', \App\Livewire\Admin\Navigation\Form::class)->name('navigation.create');
    Route::get('/navegacao/editar/{id}', \App\Livewire\Admin\Navigation\Form::class)->name('navigation.edit');
});
