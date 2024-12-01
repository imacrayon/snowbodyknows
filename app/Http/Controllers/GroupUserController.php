<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;

class GroupUserController extends Controller
{
    public function destroy(Group $group, User $user)
    {
        $group->users()->detach($user);

        if ($group->unsetRelation('users')->users->isEmpty()) {
            $group->delete();
        }

        return to_route('app');
    }
}
