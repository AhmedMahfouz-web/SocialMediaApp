<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TweetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text,
            'vote_up' => 0,
            'vote_down' => 0,
            'longitude' => fake()->latitude(-90, 90),
            'latitude' => fake()->latitude(-90, 90),
            'country' => 'Saudi Arabia',
            'user_id' => 1,
            'color' => fake()->randomElement(['blue', 'red', 'yellow', 'black', 'white']),
        ];
    }
}
