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
            'vote_up' => rand(0, 15),
            'vote_down' => rand(0, 15),
            'location' => fake()->address,
            'user_id' => 1,
            'color' => fake()->randomElement(['blue', 'red', 'yellow', 'black', 'white']),
        ];
    }
}
