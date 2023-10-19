<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class SortWishlistController extends Controller
{
    public function __invoke(Request $request, Wishlist $wishlist)
    {
        $request->validate(['sort' => ['required', 'array']]);

        $wishlist->wishes->each(fn ($wish) => $wish->forceFill([
            'order' => array_search($wish->id, $request->sort),
        ])->save());
    }
}
