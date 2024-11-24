<?php

namespace Database\Factories;

use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }

    public function forWishlist($wishlist)
    {
        return $this->hasAttached(
            $wishlist,
            ['user_id' => $wishlist->user->getKey()],
        );
    }

    public function withUser($user)
    {
        return $this->hasAttached(
            Wishlist::factory()->for($user)->create(),
            ['user_id' => $user->getKey()],
        );
    }
}
