<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wish>
 */
class WishFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wishlist_id' => Wishlist::factory(),
            'name' => fake()->catchPhrase(),
            'url' => fake()->url(),
            'description' => fake()->sentence(),
        ];
    }

    public function granted(): static
    {
        return $this->state([
            'granter_id' => User::factory(),
        ]);
    }
}
