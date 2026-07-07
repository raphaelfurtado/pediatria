<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->text(2000),
            'category' => $this->faker->randomElement(['Notícias', 'Artigos', 'Comunicados', 'Eventos']),
            'author_id' => User::factory(),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
