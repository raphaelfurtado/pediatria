<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    public function definition(): array
    {
        return [
            'photo_album_id' => PhotoAlbum::factory(),
            'image_path' => 'photos/'.$this->faker->uuid().'.jpg',
            'title' => $this->faker->optional()->sentence(3),
            'order' => $this->faker->numberBetween(0, 20),
        ];
    }
}
