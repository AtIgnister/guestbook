<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
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
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, guestbook $guestbook)
    {
        if ($request->user()->cannot('update', $guestbook)) {
            abort(403);
        }

        return view('guestbooks.edit', compact(["guestbook"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, guestbook $guestbook)
    {
        if ($request->user()->cannot('update', $guestbook)) {
            abort(403);
        }

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
    public function destroy(Request $request, guestbook $guestbook)
    {
        if ($request->user()->cannot('delete', $guestbook)) {
            abort(403);
        }

        $guestbook->delete();
        return redirect()->route('guestbooks.index')->with('success','Guestbook deleted successfully');
    }

    public function delete(Request $request, guestbook $guestbook) {
        // Our delete route is custom and has a ->can(delete) instruction,
        // so technically we don't need to do this...
        // but I'd rather have it be obvious that we're doing authorization when looking at either routes/web or the actual controller
        // Anything else would look inconsistent, and I don't want to accidentally end up removing both instructions.
        if ($request->user()->cannot('delete', $guestbook)) {
            abort(403);
        }

        return view('guestbooks.delete', compact(['guestbook']));
    }
}
