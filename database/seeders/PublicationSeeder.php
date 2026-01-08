<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publication;

class PublicationSeeder extends Seeder
{
    public function run(): void
    {
        Publication::create([
            'title' => 'Guia de Vacinação 2025/2026',
            'slug' => 'guia-vacinacao-2025-2026',
            'description' => 'Calendário vacinal atualizado.',
            'type' => 'guia',
            'year' => 2025,
        ]);

        Publication::create([
            'title' => 'Revista Paraense de Pediatria - Vol 42',
            'slug' => 'revista-paraense-pediatria-vol-42',
            'description' => 'Publicação científica trimestral.',
            'type' => 'revista',
            'year' => 2025,
        ]);
    }
}
