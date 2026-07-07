<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition(): array
    {
        $label = $this->faker->words(2, true);

        return [
            'label' => ucfirst($label),
            'url' => '/'.Str::slug($label),
            'parent_id' => null,
            'order' => $this->faker->numberBetween(0, 20),
            'is_active' => true,
        ];
    }
}
