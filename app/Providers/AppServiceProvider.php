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
    }
}
