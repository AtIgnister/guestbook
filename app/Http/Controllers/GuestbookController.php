<?php

namespace App\Http\Controllers;

use App\Models\guestbook;
use Illuminate\Http\Request;

class GuestbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guestbooks = Guestbook::where("user_id", \Auth::id())->get();
        return view("guestbooks.index", ["guestbooks" => $guestbooks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guestbooks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>'required|max:255',
            'style' => 'nullable'
        ]);

        auth()->user()->guestbooks()->create($validated);

        return redirect()->route('guestbooks.index')->with('success','Guestbook created sucessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(guestbook $guestbook)
    {
        return view('guestbooks.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(guestbook $guestbook)
    {
        return view('guestbooks.edit', compact(["guestbook"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, guestbook $guestbook)
    {
        $validated = $request->validate([
            'name' =>'required|max:255',
            'style' => 'nullable'
        ]);

        $guestbook->update($validated);

        return redirect()->route('guestbooks.index')->with('success','Guestbook saved sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(guestbook $guestbook)
    {
        //
    }
}
