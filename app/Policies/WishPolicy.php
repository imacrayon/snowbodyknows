<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wish;

class WishPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Wish $wish): bool
    {
        return $user->can('view', $wish->wishlist);
    }

    public function grant(User $user, Wish $wish): bool
    {
        return ! $wish->granter->exists && $user->can('fulfill', $wish->wishlist);
    }

    public function ungrant(User $user, Wish $wish): bool
    {
        return $user->is($wish->granter);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Wish $wish): bool
    {
        return $user->can('update', $wish->wishlist);
    }

    public function delete(User $user, Wish $wish): bool
    {
        return $this->update($user, $wish);
    }

    public function restore(User $user, Wish $wish): bool
    {
        return $this->delete($user, $wish);
    }

    public function forceDelete(User $user, Wish $wish): bool
    {
        return false;
    }
}
