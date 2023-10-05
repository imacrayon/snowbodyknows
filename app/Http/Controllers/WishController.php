<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function create(Wishlist $wishlist)
    {
        return view('wishes.create', [
            'wishlist' => $wishlist,
            'wish' => new Wish,
        ]);
    }

    public function store(Request $request, Wishlist $wishlist)
    {
        $wishlist->wishes()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]));

        return to_route('wishlists.show', $wishlist);
    }

    public function edit(Wishlist $wishlist, Wish $wish)
    {
        return view('wishes.edit', [
            'wishlist' => $wishlist,
            'wish' => $wish,
        ]);

    }

    public function update(Request $request, Wishlist $wishlist, Wish $wish)
    {
        $wish->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]));

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist, Wish $wish)
    {
        $wish->delete();

        return to_route('wishlists.show', $wishlist);
    }
}
