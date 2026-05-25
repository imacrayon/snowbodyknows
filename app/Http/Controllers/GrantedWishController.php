<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GrantedWishController extends Controller
{
    public function store(Request $request, Wish $wish): RedirectResponse
    {
        $wish->grant($request->user())->save();

        return back();
    }

    public function destroy(Wish $wish): RedirectResponse
    {
        $wish->ungrant()->save();

        return back();
    }
}
