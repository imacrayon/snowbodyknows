<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;

class PartyViewerController extends Controller
{
    public function create(Request $request, Party $party)
    {
        if (is_null($request->user())) {
            return to_route('login', ['party' => $party->invite_code]);
        }

        return view('parties.viewers.create', [
            'party' => $party,
        ]);
    }
    
    public function store(Request $request, Party $party)
    {
        if ($party->user->isNot($request->user())) {
            $party->viewers()->syncWithoutDetaching($request->user());
        }

        return to_route('parties.show', $party);
    }
    
    public function destroy(Request $request, Party $party, User $user)
    {
        dd('parties destroy');
        // $party->viewers()->detach($user);

        // if ($request->user()->is($user)) {
        //     return to_route('app');
        // }

        // return to_route('parties.show', $party);
    }
}