<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'user_id' => rand(1, 25),
            'tweet_id' => rand(0, 25),
        ];
    }
}
