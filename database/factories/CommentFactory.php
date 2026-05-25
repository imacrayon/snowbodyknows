<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commentable_id' => 1,
            'commentable_type' => Wishlist::class,
            'content' => fake()->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
