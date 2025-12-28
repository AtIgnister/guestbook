<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use App\Models\GuestbookEntries;
use Illuminate\Http\Request;

class EntriesController extends Controller
{
    public function create(Request $request, Guestbook $guestbook)
    {
        // Pass the guestbook to the view
        return view('entries.create', compact('guestbook'));
    }

    public function store(Request $request, Guestbook $guestbook)
    {
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

    public function edit(Request $request, Guestbook $guestbook) {
        $entries = $guestbook->entries()->orderBy('created_at', 'desc')->get();
        return view("entries.edit", ["entries" => $entries, "guestbook"=> $guestbook]);
    }

    public function editAll(Request $request)
    {
        $entries = GuestbookEntries::whereHas('guestbook', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->with('guestbook')
        ->latest()
        ->get();
    
        return view('entries.editAll', compact('entries'));
    }
    public function destroy(GuestbookEntries $entry)
    {
        $entry->delete();

        return redirect()
            ->route('entries.editAll')
            ->with('status', 'Entry deleted');
    }
}
