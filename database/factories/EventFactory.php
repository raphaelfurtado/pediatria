<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $start = $this->faker->dateTimeBetween('now', '+3 months');

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 999999),
            'description' => $this->faker->paragraph(),
            'date_start' => $start,
            'date_end' => (clone $start)->modify('+2 hours'),
            'location' => $this->faker->city(),
            'image_path' => null,
            'type' => $this->faker->randomElement(['presencial', 'online', 'hibrido']),
            'registration_link' => $this->faker->optional()->url(),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
