<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request, Wishlist $wishlist)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $group = $wishlist->groups()->create([
            'name' => $request->name ?? __('Untitled Group'),
            'description' => $request->description,
        ], [
            'user_id' => $request->user()->getKey(),
        ]);

        return to_route('groups.show', $group);
    }

    public function show(Request $request, Group $group)
    {
        [$yourWishlists, $otherWishlists] = $group->wishlists()->withCount('wishes', 'user')->with('user')->get()->partition(
            fn ($wishlist) => $wishlist->user->is($request->user())
        );

        return view('groups.show', [
            'group' => $group,
            'yourWishlists' => $yourWishlists,
            'otherWishlists' => $otherWishlists,
            'participants' => $group->participants,
        ]);
    }

    public function edit(Group $group)
    {
        return view('groups.edit', [
            'group' => $group,
        ]);

    }

    public function update(Request $request, Group $group)
    {
        $group->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]));

        return to_route('groups.show', $group);
    }
}
