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
        ]));

        return to_route('parties.show', $party);
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Party $party)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        //
    }
}
