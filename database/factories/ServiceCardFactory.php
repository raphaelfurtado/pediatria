<?php

namespace Database\Factories;

use App\Models\ServiceCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceCardFactory extends Factory
{
    protected $model = ServiceCard::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->randomElement(['star', 'badge', 'school', 'calendar_month', 'chat_bubble']),
            'color' => $this->faker->randomElement(ServiceCard::COLORS),
            'link' => '#',
            'cta_text' => 'Saiba mais',
            'order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
