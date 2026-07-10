<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Backup diário do banco de dados (requer cron chamando `php artisan schedule:run`).
Schedule::command('backup:run')->dailyAt('03:00')->withoutOverlapping();
