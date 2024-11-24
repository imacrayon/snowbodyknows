<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return view('wishlists.index', [
            'wishlists' => $request->user()->wishlists()->withCount('wishes', 'groups')->get(),
            'groups' => $request->user()->groups()->withCount('users')->get(),
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

    public function show(Request $request, Wishlist $wishlist)
    {
        if ($request->user()->can('fulfill', $wishlist)) {
            return view('wishlists.fulfill', [
                'wishlist' => $wishlist,
                'wishes' => $wishlist->wishes()->with('granter')->orderBy('granter_id', 'asc')->orderBy('order')->get(),
                'comments' => $wishlist->comments()->with('user')->get(),
            ]);
        }

        return view('wishlists.show', [
            'wishlist' => $wishlist,
            'wishes' => $wishlist->wishes()->orderBy('order')->get(),
            'groups' => $wishlist->groups()->withCount('users')->get(),
            'comments' => $wishlist->comments()->with('user')->get(),
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

    public function destroy(Request $request, Wishlist $wishlist)
    {
        $request->validateWithBag('wishlistDeletion', [
            'wishlist_name' => ['required', 'string', 'max:255', 'same:original_name'],
        ]);

        $wishlist->delete();

        return to_route('app');
    }
}
