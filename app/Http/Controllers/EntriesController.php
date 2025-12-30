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
        $defaultPerPage = 10; // TODO: change pagination template styling
        // Get 'per_page' from URL query, cast to int
        $perPage = (int) $request->query('per_page', $defaultPerPage);
        // Cap the maximum allowed per page
        $perPage = min($perPage, 50); // max 50 items per page
        $search = $request->query('search'); // get search query

        if ($request->user()->hasRole('admin')) { 
            $entries = GuestbookEntries::with('guestbook')
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('website', 'like', "%{$search}%")
                        ->orWhere('comment', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate($perPage)
                ->withQueryString();;
        } else {
            $entries = GuestbookEntries::whereHas('guestbook', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })->with('guestbook')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('comment', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
        }
    
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
