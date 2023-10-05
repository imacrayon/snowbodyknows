<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;

class WishlistPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user->is($user) || $wishlist->members->contains($user);
    }

    public function fulfill(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->members->contains($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user->is($user);
    }

    public function delete(User $user, Wishlist $wishlist): bool
    {
        return $this->update($user, $wishlist);
    }

    public function restore(User $user, Wishlist $wishlist): bool
    {
        return $this->delete($user, $wishlist);
    }

    public function forceDelete(User $user, Wishlist $wishlist): bool
    {
        return false;
    }
}