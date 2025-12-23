<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\Request;

class EntriesController extends Controller
{
    public function create($guestbook_id)
    {
        // Get the guestbook by ID
        $guestbook = Guestbook::findOrFail($guestbook_id);

        // Pass the guestbook to the view
        return view('entries.create', compact('guestbook'));
    }

    public function store(Request $request, $guestbook_id)
    {
        $guestbook = Guestbook::findOrFail($guestbook_id);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'comment' => 'required|max:3000',
            'website' => 'nullable|url',
        ]);

        // Assuming you have a one-to-many relation 'entries'
        $guestbook->entries()->create($validated);

        return redirect()->route('entries.index', ["guestbook_id" => $guestbook_id])->with('success','Entry created sucessfully');
    }

    public function index(Request $request, $guestbook_id) { 
        $guestbook = Guestbook::find($guestbook_id);

        if(!$guestbook) abort(404);

        $entries = $guestbook->entries;
        return view('entries.index', ['entries' => $entries, 'guestbook' => $guestbook]);
    }
}
