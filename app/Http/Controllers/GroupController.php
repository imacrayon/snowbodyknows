<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GroupController extends Controller
{
    const NEW_GROUP = 'NEW_GROUP';

    public function create(Request $request, Wishlist $wishlist): View
    {
        return view('groups.create', [
            'wishlist' => $wishlist,
            'yourGroups' => $request->user()->groups()->withCount('users')->get(),
        ]);
    }

    /**
     * Share the wishlist with exactly the selected groups, creating a new group when requested.
     */
    public function store(Request $request, Wishlist $wishlist): RedirectResponse
    {
        $request->validate([
            'groups' => ['nullable', 'array'],
            'groups.*' => [Rule::in($request->user()->groups->pluck('id')->push(self::NEW_GROUP))],
        ]);

        $selected = $request->collect('groups');

        $newGroup = DB::transaction(function () use ($request, $wishlist, $selected) {
            $wishlist->groups()->sync($selected->reject(self::NEW_GROUP));

            if (! $selected->contains(self::NEW_GROUP)) {
                return null;
            }

            $group = $wishlist->groups()->create(['name' => __('Untitled Group')]);
            $group->users()->attach($request->user());

            return $group;
        });

        if ($newGroup) {
            return to_route('groups.show', $newGroup);
        }

        return to_route('wishlists.show', $wishlist);
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
