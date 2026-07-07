<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;

class FeedController extends Controller
{
    public function show(Guestbook $guestbook)
    {
        $entries = $entries = $guestbook->entries()
                ->where('is_reply', false)
                ->latest()
                ->get();

        $updated = optional($entries->first())->updated_at?->toAtomString();

        return response()
            ->view('guestbooks.feed', [
                'guestbook' => $guestbook,
                'entries' => $entries,
                'updated' => $updated
            ])
            ->header('Content-Type', 'application/atom+xml');
    }
}