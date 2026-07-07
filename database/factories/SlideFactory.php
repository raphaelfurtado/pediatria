<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlideFactory extends Factory
{
    protected $model = Slide::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->optional()->sentence(6),
            'image_path' => 'slides/'.$this->faker->uuid().'.jpg',
            'button_text' => $this->faker->optional()->words(2, true),
            'button_link' => $this->faker->optional()->url(),
            'order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
