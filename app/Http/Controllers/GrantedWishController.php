<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\Request;

class GrantedWishController extends Controller
{
    public function store(Request $request, Wish $wish)
    {
        $wish->grant($request->user())->save();

        return back();
    }

    public function destroy(Wish $wish)
    {
        $wish->ungrant()->save();

        return back();
    }
}
