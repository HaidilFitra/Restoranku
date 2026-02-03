<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category_id' => \App\Models\Category::factory(),
            'img' => $this->faker->imageUrl(640, 480, 'food', true),
            'is_available' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}
