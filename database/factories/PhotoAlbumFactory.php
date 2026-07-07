<?php

namespace Database\Factories;

use App\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PhotoAlbumFactory extends Factory
{
    protected $model = PhotoAlbum::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 999999),
            'description' => $this->faker->paragraph(),
            'cover_image' => null,
            'is_active' => true,
        ];
    }
}
