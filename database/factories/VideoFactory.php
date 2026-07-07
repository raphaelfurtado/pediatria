<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'youtube_id' => $this->faker->regexify('[A-Za-z0-9_-]{11}'),
            'description' => $this->faker->optional()->paragraph(),
            'is_featured' => $this->faker->boolean(20),
            'is_active' => true,
        ];
    }
}
