<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class GroupFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }

    public function withWishlist(Wishlist $wishlist): static
    {
        return $this->hasAttached($wishlist)
            ->hasAttached($wishlist->user);
    }

    public function withUser(User $user): static
    {
        return $this->hasAttached(Wishlist::factory()->for($user)->create())
            ->hasAttached($user);
    }
}
