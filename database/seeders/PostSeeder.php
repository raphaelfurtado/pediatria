<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@sopape.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $posts = [
            [
                'title' => 'Campanha de Vacinação 2026',
                'category' => 'Comunidade',
                'excerpt' => 'SOPAPE inicia campanha de conscientização sobre a importância da vacinação infantil.',
                'content' => '<p>A Sociedade Paraense de Pediatria lança hoje a campanha...</p>',
                'is_featured' => true,
            ],
            [
                'title' => 'Novo Protocolo para Bronquiolite',
                'category' => 'Científico',
                'excerpt' => 'Diretrizes atualizadas para o manejo da bronquiolite viral aguda.',
                'content' => '<p>Confira as novas diretrizes publicadas pela SBP e adotadas pela SOPAPE...</p>',
                'is_featured' => false,
            ],
            [
                'title' => 'Jantar de Confraternização dos Sócios',
                'category' => 'Social',
                'excerpt' => 'Evento reuniu pediatras de todo o estado em noite de celebração.',
                'content' => '<p>Na última sexta-feira, a SOPAPE realizou...</p>',
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $post) {
            Post::create(array_merge($post, [
                'slug' => \Illuminate\Support\Str::slug($post['title']),
                'author_id' => $user->id,
                'published_at' => now(),
            ]));
        }

        // Generate more dummy posts
        Post::factory(10)->create([
            'author_id' => $user->id,
            'published_at' => now(),
        ]);
    }
}
