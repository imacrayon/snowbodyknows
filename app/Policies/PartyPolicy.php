<?php

namespace App\Policies;

use App\Models\Party;
use App\Models\User;

class PartyPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Party $party): bool
    {
        return $party->user_created_by->is($user) || $party->viewers->contains($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Party $party): bool
    {
        return $party->user_created_by->is($user);
    }

    public function delete(User $user, Party $party): bool
    {
        return $this->update($user, $party);
    }

    public function restore(User $user, Party $party): bool
    {
        return $this->delete($user, $party);
    }

    public function forceDelete(User $user, Party $party): bool
    {
        return false;
    }
}
