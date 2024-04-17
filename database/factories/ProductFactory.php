<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word,
            'description' => fake()->sentence,
            'image' => fake()->imageUrl(400, 300, 'products'), 
            'price' => fake()->randomFloat(2, 10, 1000), // Random price between 10 and 1000 with 2 decimal places
            'slug' => Str::slug(fake()->unique()->word), // Generate a unique slug based on a random word
            'is_active' => fake()->boolean(90), // 90% chance of being active
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }
}
