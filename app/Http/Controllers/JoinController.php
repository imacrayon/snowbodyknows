<?php

namespace App\Http\Controllers;

use App\Models\Group;

class JoinController extends Controller
{
    public function __invoke(Group $group)
    {
        return view('join', [
            'group' => $group,
            'users' => $group->users,
        ]);
    }
}
