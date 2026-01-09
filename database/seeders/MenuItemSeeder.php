<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Home', 'url' => '/', 'order' => 1],
            ['label' => 'Institucional', 'url' => '/sobre', 'order' => 2],
            ['label' => 'Biblioteca', 'url' => '/biblioteca', 'order' => 3],
            ['label' => 'Cursos e Eventos', 'url' => '/eventos', 'order' => 4],
            ['label' => 'Notícias', 'url' => '/noticias', 'order' => 5],
            ['label' => 'Galeria', 'url' => '/galeria', 'order' => 6],
            ['label' => 'Vídeos', 'url' => '/videos', 'order' => 7],
            ['label' => 'Contato', 'url' => '#', 'order' => 8],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
