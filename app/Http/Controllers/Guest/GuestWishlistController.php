<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\View\View;

class GuestWishlistController extends Controller
{
    public function show(): View
    {
        $wishlist = new Wishlist(session('wishlist') ?? [
            'name' => 'My wishlist',
            'id' => 0,
            'wishes' => [],
        ]);
        $wishes = $wishlist->wishes()->get();
        foreach ($wishlist->toArray()['wishes'] as $wish) {
            $wishes->add(new Wish($wish));
        }
        if (session('wishlist') === null) {
            session(['wishlist' => $wishlist->toArray()]);
        }

        return view('guests.wishlists.show', [
            'wishlist' => $wishlist,
            'wishes' => $wishes,
        ]);
    }
}
