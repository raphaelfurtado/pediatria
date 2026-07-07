<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 999999),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['livro', 'manual', 'guia', 'revista']),
            'cover_image' => null,
            'file_path' => null,
            'external_link' => $this->faker->optional()->url(),
            'year' => $this->faker->numberBetween(2000, 2026),
        ];
    }
}
