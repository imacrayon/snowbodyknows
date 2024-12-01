<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class JoinController extends Controller
{
    public function __invoke(Request $request, Group $group)
    {
        if ($request->user()) {
            return to_route('groups.wishlists.store', $group);
        }

        return view('join', [
            'group' => $group,
            'users' => $group->users,
        ]);
    }
}
