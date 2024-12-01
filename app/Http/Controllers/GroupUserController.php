<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GroupUserController extends Controller
{
    public function destroy(Group $group, User $user)
    {
        DB::transaction(function () use ($group, $user) {
            $wishlists = $group->wishlists()->whereRelation(
                'user', 'users.id', $user->id
            )->get()->pluck('id')->all();
            $group->wishlists()->detach($wishlists);
            $group->users()->detach($user);
        });

        if ($group->unsetRelation('users')->users->isEmpty()) {
            $group->delete();
        }

        return to_route('app');
    }
}
