<?php

namespace App\Http\Controllers\Guest;

use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestWishController extends Controller
{
    public function create()
    {
        if (session('wishlist') === null) {

            return to_route('guest.wishlists.show');
        }

        return view('guest.wishes.create', [
            'wishlist' => new Wishlist(session('wishlist')),
            'wish' => new Wish,
        ]);
    }

    public function store(Request $request, Wishlist $wishlist)
    {
        $wishlist = session('wishlist');

        $newWishId = 1;
        if (count($wishlist['wishes']) > 0) {
            $newWishId = max(array_values(array_column(session('wishlist')['wishes'], 'id'))) + 1;
        }

        $wishlist['wishes'][] = array_merge($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url:http,https', 'max:2000'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]), [ 'id' => $newWishId ]);
        $wishlist['wishes'] = array_values($wishlist['wishes']);

        session(['wishlist' => $wishlist]);

        return to_route('guest.wishlists.show');
    }

    public function edit(int $wishId)
    {
        if (session('wishlist') === null) {

            return to_route('guest.wishlists.show');
        }

        $foundWishKey = array_search($wishId, array_column(session('wishlist')['wishes'], 'id'));
        if ($foundWishKey === false) {

            return to_route('guest.wishlists.show');
        }

        return view('guest.wishes.edit', [
            'wishlist' => new Wishlist(session()->get('wishlist')),
            'wish' => new Wish(session('wishlist')['wishes'][$foundWishKey]),
        ]);

    }

    public function update(Request $request, int $wishId)
    {
        $foundWishKey = array_search($wishId, array_column(session('wishlist')['wishes'], 'id'));
        if ($foundWishKey === false) {

            return to_route('guest.wishlists.show');
        }
        $wishlist = session('wishlist');
        $wishlist['wishes'][$foundWishKey] = array_merge($wishlist['wishes'][$foundWishKey], $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url:http,https', 'max:2000'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]));

        session(['wishlist' => $wishlist]);

        return to_route('guest.wishlists.show');
    }

    public function destroy(int $wishId)
    {
        $foundWishKey = array_search($wishId, array_column(session('wishlist')['wishes'], 'id'));
        if ($foundWishKey === false) {

            return to_route('guest.wishlists.show');
        }

        $wishlist = session('wishlist');
        unset($wishlist['wishes'][$foundWishKey]);
        $wishlist['wishes'] = array_values($wishlist['wishes']);
        session(['wishlist' => $wishlist]);
        
        return to_route('guest.wishlists.show');
    }
}

