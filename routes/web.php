<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\MemberController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/noticias', [PostController::class, 'index'])->name('posts.index');
Route::get('/noticias/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
Route::get('/publicacoes', [PublicationController::class, 'index'])->name('publications.index');
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

    // Future routes for Events...
});
