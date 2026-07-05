<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestbookEntries;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function create(Request $request, GuestbookEntries $entry)
    {
        if (Auth::user()->cannot('reply', $entry)) {
            abort(403);
        }

        if($entry->is_reply) {
            abort(403);
        }

        $validated = $request->validate([
            'comment' => ['required', 'string'],
        ]);

        GuestbookEntries::create([
            'guestbook_id' => $entry->guestbook->id,
            'parent_entry_id' => $entry->parent_entry_id ?? $entry->id,
            'is_reply' => true,

            'name' => $entry->guestbook->author_name ?? 'Author',
            'website' => null,
            'comment' => $validated['comment'],

            'approved' => !$entry->guestbook->requires_approval,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Reply posted successfully.');
    }
}
