<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Força pt_BR independente do APP_LOCALE do .env (datas, diffForHumans, <html lang>).
        \Illuminate\Support\Facades\App::setLocale('pt_BR');
        \Carbon\Carbon::setLocale('pt_BR');

        // Log de auditoria: registra criação/edição/exclusão nos models de conteúdo.
        $observed = [
            \App\Models\Post::class,
            \App\Models\Event::class,
            \App\Models\Publication::class,
            \App\Models\Video::class,
            \App\Models\User::class,
            \App\Models\ServiceCard::class,
            \App\Models\Slide::class,
            \App\Models\PhotoAlbum::class,
            \App\Models\Page::class,
        ];

        foreach ($observed as $model) {
            $model::observe(\App\Observers\ActivityObserver::class);
        }
    }
}
