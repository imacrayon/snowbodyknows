<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupUserController extends Controller
{
    public function create(Request $request, Group $group)
    {
        return view('groups.users.create', [
            'group' => $group,
            'users' => $group->users,
            'wishlists' => $request->user()->wishlists()->withCount('wishes', 'groups')->get(),
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'wishlist_id' => ['nullable', Rule::in($request->user()->wishlists->pluck('id'))],
        ]);

        $wishlistId = $request->wishlist_id;
        if (is_null($wishlistId)) {
            $wishlistId = $request->user()->wishlists()
                ->create(['name' => __('Untitled Wishlist')])->id;
        }

        $group->join($request->user(), $wishlistId);

        return to_route('groups.show', $group);
    }

    public function destroy(Group $group, User $user)
    {
        $group->users()->detach($user);

        if ($group->unsetRelation('users')->users->isEmpty()) {
            $group->delete();
        }

        return to_route('app');
    }
}
