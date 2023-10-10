<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistViewerController extends Controller
{
    public function create(Request $request, Wishlist $wishlist)
    {
        if (is_null($request->user())) {
            return to_route('login', ['wishlist' => $wishlist->invite_code]);
        }

        return view('wishlists.viewers.create', [
            'wishlist' => $wishlist,
        ]);
    }

    public function store(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user->isNot($request->user())) {
            $wishlist->viewers()->syncWithoutDetaching($request->user());
        }

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Request $request, Wishlist $wishlist, User $user)
    {
        $wishlist->viewers()->detach($user);

        if ($request->user()->is($user)) {
            return to_route('app');
        }

        return to_route('wishlists.show', $wishlist);
    }
}
