<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Group $group): bool
    {
        return $group->users->contains($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Group $group): bool
    {
        return $group->users->contains($user);
    }

    public function delete(User $user, Group $group): bool
    {
        return $group->user->is($user);
    }

    public function restore(User $user, Group $group): bool
    {
        return $this->delete($user, $group);
    }

    public function forceDelete(User $user, Group $group): bool
    {
        return false;
    }
}
