<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupWishlistController extends Controller
{
    const NEW_WISHLIST = 'NEW_WISHLIST';

    public function create(Request $request, Group $group)
    {
        return view('groups.wishlists.create', [
            'group' => $group,
            'users' => $group->users,
            'yourWishlists' => $request->user()->wishlists()->withCount('wishes', 'groups')->get(),
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'wishlists' => ['nullable', 'array'],
            'wishlists.*' => [Rule::in($request->user()->wishlists->pluck('id')->push(self::NEW_WISHLIST))],
        ]);

        $selected = $request->input('wishlists', []);
        $key = array_search(self::NEW_WISHLIST, $selected);
        if ($key !== false) {
            $selected[$key] = $request->user()->wishlists()
                ->create(['name' => __('Untitled Wishlist')])->getKey();
        }
        $userId = $request->user()->getKey();
        $current = $group->wishlists()->whereRelation(
            'user', 'users.id', $userId
        )->get()->pluck('id')->all();

        DB::transaction(function () use ($group, $selected, $current, $userId) {
            $group->users()->syncWithoutDetaching($userId);
            $group->wishlists()->detach(array_diff($current, $selected));
            $group->wishlists()->attach(array_diff($selected, $current));
        });

        return to_route('groups.show', $group);
    }

    public function edit(Request $request, Group $group)
    {
        return view('groups.wishlists.edit', [
            'group' => $group,
            'wishlists' => $group->wishlists,
            'yourWishlists' => $request->user()->wishlists()->withCount('wishes', 'groups')->get(),
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'wishlists' => ['nullable', 'array'],
            'wishlists.*' => [Rule::in($request->user()->wishlists->pluck('id')->push(self::NEW_WISHLIST))],
        ]);

        $selected = $request->input('wishlists', []);
        $key = array_search(self::NEW_WISHLIST, $selected);
        if ($key !== false) {
            $selected[$key] = $request->user()->wishlists()
                ->create(['name' => __('Untitled Wishlist')])->getKey();
        }

        $current = $group->wishlists()->whereRelation(
            'user', 'users.id', $request->user()->getKey()
        )->get()->pluck('id')->all();

        DB::transaction(function () use ($group, $selected, $current) {
            $group->wishlists()->detach(array_diff($current, $selected));
            $group->wishlists()->attach(array_diff($selected, $current));
        });

        return to_route('groups.show', $group);
    }
}
