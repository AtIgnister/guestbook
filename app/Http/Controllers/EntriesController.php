<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\Request;

class EntriesController extends Controller
{
    public function create(Request $request, Guestbook $guestbook)
    {
        if ($request->user()->cannot('create', $guestbook)) {
            abort(403);
        }

        // Pass the guestbook to the view
        return view('entries.create', compact('guestbook'));
    }

    public function store(Request $request, Guestbook $guestbook)
    {
        if ($request->user()->cannot('store', $guestbook)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'comment' => 'required|max:20000',
            'website' => 'nullable|url',
        ]);

        // Assuming you have a one-to-many relation 'entries'
        $guestbook->entries()->create($validated);

        return redirect()->route('entries.index', ["guestbook" => $guestbook])->with('success','Entry created sucessfully');
    }

    public function index(Request $request, Guestbook $guestbook) { 
        $entries = $guestbook->entries()->orderBy('created_at', 'desc')->get();
        return view('entries.index', ['entries' => $entries, 'guestbook' => $guestbook]);
    }
}
