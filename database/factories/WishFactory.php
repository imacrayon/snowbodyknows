<?php

namespace Database\Factories;

use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'wishlist_id' => Wishlist::factory(),
            'name' => $this->faker->catchPhrase(),
            'url' => $this->faker->url(),
            'description' => $this->faker->sentence(),
        ];
    }
}
