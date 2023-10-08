<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return view('wishlists.index', [
            'wishlists' => $request->user()->wishlists,
            'joinedWishlists' => $request->user()->joinedWishlists,
        ]);
    }

    public function create()
    {
        return view('wishlists.create', [
            'wishlist' => new Wishlist,
        ]);
    }

    public function store(Request $request)
    {
        $wishlist = $request->user()->wishlists()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]));

        return to_route('wishlists.show', $wishlist);
    }

    public function show(Wishlist $wishlist)
    {
        return view('wishlists.show', [
            'wishlist' => $wishlist,
            'wishes' => $wishlist->wishes,
        ]);
    }

    public function edit(Wishlist $wishlist)
    {
        return view('wishlists.edit', [
            'wishlist' => $wishlist,
        ]);

    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $wishlist->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]));

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();

        return to_route('app');
    }
}
