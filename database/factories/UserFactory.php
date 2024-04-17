<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName,
            'password' => bcrypt('password'), // You can adjust this as needed
            'avatar' => fake()->imageUrl(200, 200, 'people'), // Example of generating a random avatar URL
            'type' => fake()->randomElement(['normal', 'gold','silver']),
            'is_active' => fake()->boolean(90), // 90% chance of being active
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
