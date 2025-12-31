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
        
        $guestbook->entries()->create(array_merge(
            $validated,
            [
                'approved' => ! $guestbook->requires_approval,
            ]
        ));

        return redirect()->route('entries.index', ["guestbook" => $guestbook])->with('success','Entry created sucessfully');
    }

    public function index(Request $request, Guestbook $guestbook) { 
        $entries = $guestbook->entries()
            ->where('approved', true)
            ->latest()
            ->get();
        
        return view('entries.index', ['entries' => $entries, 'guestbook' => $guestbook]);
    }

    public function edit(Request $request, Guestbook $guestbook) {
        $entries = $guestbook->entries()->orderBy('created_at', 'desc')->get();
        return view("entries.edit", ["entries" => $entries, "guestbook"=> $guestbook]);
    }

    public function editAll(Request $request)
    {
        $perPage = min(
            (int) $request->query('per_page', 10),
            50
        );
        
        $entries = GuestbookEntries::query()
            ->visibilityRestriction($request->user())
            ->search($request->query('search'))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    
        return view('entries.editAll', compact('entries'));
    }
    public function destroy(GuestbookEntries $entry)
    {
        $entry->delete();

        return redirect()
            ->route('entries.editAll')
            ->with('status', 'Entry deleted');
    }

    public function approve(GuestbookEntries $entry) {
        if($entry->approved === false) {
            $entry->approved = true;
        }
        $entry->save();

        return back()->with('success', 'Entry approved!');
    }
}
