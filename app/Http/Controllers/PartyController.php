<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;

class PartyController extends Controller
{
    public function index(Request $request)
    {
        return view('parties.index', [
            'parties' => $request->user()->parties()->get(),
            'joinedParties' => $request->user()->joinedParties()->withCount('viewers')->get(),
        ]);
    }

    public function create()
    {
        return view('parties.create', [
            'party' => new Party
        ]);
    }

    public function store(Request $request)
    {
        $party = $request->user()->parties()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'address' => ['string', 'max:255'],
            'start_date' => ['date'],
            'start_time' => ['date_format:H:i'],
            'end_date' => ['date'],
            'end_time' => ['date_format:H:i'],
        ]));

        return to_route('parties.show', $party);
    }

    public function show(Request $request, Party $party)
    {
        if ($request->user()->can('fulfill', $party)) {
            return view('parties.fulfill', [
                'party' => $party// ,
                // 'wishes' => $wishlist->wishes()->with('granter')->orderBy('granter_id', 'asc')->orderBy('order')->get(),
            ]);
        }

        return view('parties.show', [
            'party' => $party// ,
            // 'wishes' => $wishlist->wishes()->orderBy('order')->get(),
        ]);
    }

    public function edit(Party $party)
    {
        return view('parties.edit', [
            'party' => $party,
        ]);

    }

    public function update(Request $request, Party $party)
    {
        $party->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'address' => ['string', 'max:255'],
            'start_date' => ['date'],
            'start_time' => ['date_format:H:i'],
            'end_date' => ['date'],
            'end_time' => ['date_format:H:i'],
        ]));

        return to_route('parties.show', $party);
    }

    public function destroy(Request $request, Party $party)
    {   
        $request->validateWithBag('partyDeletion', [
            'party_name' => ['required', 'string', 'max:255', 'same:original_name'],
        ]);

        $party->delete();

        return to_route('app');
    }
}
