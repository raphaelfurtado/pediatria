<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title' => 'XXV Congresso Paraense de Pediatria',
            'slug' => 'xxv-congresso-paraense-de-pediatria',
            'description' => 'O maior evento da pediatria no norte do país.',
            'date_start' => now()->addMonths(2),
            'date_end' => now()->addMonths(2)->addDays(3),
            'location' => 'Hangar Centro de Convenções',
            'type' => 'presencial',
            'is_featured' => true,
        ]);

        Event::create([
            'title' => 'Webinar: Nutrição Infantil',
            'slug' => 'webinar-nutricao-infantil',
            'description' => 'Atualizações em introdução alimentar.',
            'date_start' => now()->addWeeks(2),
            'location' => 'Online (Zoom)',
            'type' => 'online',
            'is_featured' => false,
        ]);
    }
}
