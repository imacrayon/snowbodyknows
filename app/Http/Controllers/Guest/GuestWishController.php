<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishRequest;
use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuestWishController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (session('wishlist') === null) {
            return to_route('guests.wishlists.show');
        }

        return view('guests.wishes.create', [
            'wishlist' => new Wishlist(session('wishlist')),
            'wish' => new Wish,
        ]);
    }

    public function store(WishRequest $request, Wishlist $wishlist): RedirectResponse
    {
        $wishlist = session('wishlist');

        $wishlist['wishes'][] = array_merge($request->validated(), ['id' => count($wishlist['wishes'])]);

        session(['wishlist' => $wishlist]);

        return to_route('guests.wishlists.show');
    }

    public function edit(int $wishId): View|RedirectResponse
    {
        if (session('wishlist') === null) {
            return to_route('guests.wishlists.show');
        }

        $foundWishKey = array_search($wishId, array_column(session('wishlist')['wishes'], 'id'));
        if ($foundWishKey === false) {
            return to_route('guests.wishlists.show');
        }

        return view('guests.wishes.edit', [
            'wishlist' => new Wishlist(session()->get('wishlist')),
            'wish' => new Wish(session('wishlist')['wishes'][$foundWishKey]),
        ]);
    }

    public function update(WishRequest $request, int $wishId): RedirectResponse
    {
        $foundWishKey = array_search($wishId, array_column(session('wishlist')['wishes'], 'id'));
        if ($foundWishKey === false) {
            return to_route('guests.wishlists.show');
        }
        $wishlist = session('wishlist');
        $wishlist['wishes'][$foundWishKey] = array_merge($wishlist['wishes'][$foundWishKey], $request->validated());

        session(['wishlist' => $wishlist]);

        return to_route('guests.wishlists.show');
    }

    public function destroy(int $wishId): RedirectResponse
    {
        $foundWishKey = array_search($wishId, array_column(session('wishlist')['wishes'], 'id'));
        if ($foundWishKey === false) {
            return to_route('guests.wishlists.show');
        }

        $wishlist = session('wishlist');
        unset($wishlist['wishes'][$foundWishKey]);
        session(['wishlist' => $wishlist]);

        return to_route('guests.wishlists.show');
    }
}
