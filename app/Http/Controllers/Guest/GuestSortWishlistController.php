<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestSortWishlistController extends Controller
{
    public function __invoke(Request $request)
    {
        if (session('wishlist') === null) {

            return to_route('guests.wishlists.show');
        }

        $wishlist = session('wishlist');
        $values = $request->validate(['sort' => ['required', 'array']])['sort'];
        $newWishes = [];
        foreach($values as $v) {
            $foundWishKey = array_search((int) $v, array_column($wishlist['wishes'], 'id'));
            $newWishes[] = $wishlist['wishes'][$foundWishKey];
        }
        $wishlist['wishes'] = $newWishes;

        session(['wishlist' => $wishlist]);
    }
}

