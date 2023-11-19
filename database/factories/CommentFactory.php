<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commentable_id' => 1,
            'commentable_type' => \App\Models\Wishlist::class,
            'content' => $this->faker->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
