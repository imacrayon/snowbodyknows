<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function store(Request $request, Wishlist $wishlist): RedirectResponse
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $group = DB::transaction(function () use ($request, $wishlist) {
            $group = $wishlist->groups()->create([
                'name' => $request->name ?? __('Untitled Group'),
                'description' => $request->description,
            ]);
            $group->users()->syncWithoutDetaching($request->user());

            return $group;
        });

        return to_route('groups.show', $group);
    }

    public function show(Request $request, Group $group): View
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

    public function edit(Group $group): View
    {
        return view('groups.edit', [
            'group' => $group,
        ]);
    }

    public function update(Request $request, Group $group): RedirectResponse
    {
        $group->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]));

        return to_route('groups.show', $group);
    }
}
