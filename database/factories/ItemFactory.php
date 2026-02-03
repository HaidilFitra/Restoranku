<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10000, 100000),
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'img' => fake()->RandomElement([
                'https://images.unsplash.com/photo-1572656631137-7935297eff55',
                'https://plus.unsplash.com/premium_photo-1668146927669-f2edf6e86f6f',
                'https://images.unsplash.com/photo-1513104890138-7c749659a591',
                'https://plus.unsplash.com/premium_photo-1683619761468-b06992704398',
                'https://images.unsplash.com/photo-1694853651800-3e9b4aa96a42',
            ]),
            'is_available' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}
