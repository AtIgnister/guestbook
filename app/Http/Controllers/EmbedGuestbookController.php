<?php

namespace App\Http\Controllers;

use App\Helpers\UserBanHelper;
use App\Models\Guestbook;
use App\Notifications\GuestbookEntryNotification;
use App\Services\AudioCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmbedGuestbookController extends Controller
{
    public function index(Request $request, Guestbook $guestbook) {
        $guestbookAdmin = $guestbook->user()->first();
        if(UserBanHelper::isBanned($guestbookAdmin)) {
            return view('guestbooks.adminIsBanned');
        }

        $entries = $guestbook->entries()
            ->where('approved', true)
            ->latest()
            ->get();
        
        return view('entries.index', ['entries' => $entries, 'guestbook' => $guestbook, 'is_embed' => true]);
    }

    public function create(Guestbook $guestbook)
    {
        return view('embed.guestbook', compact('guestbook'));
    }

    public function store(Request $request, Guestbook $guestbook)
    {
        $rules = [
            'name' => 'required|max:255',
            'comment' => 'required|max:20000',
            'website' => 'nullable|url',
            'captcha_type' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails() || !AudioCaptcha::captcha_verify($request, $request->input('captcha_type'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid captcha. Please try again.',
            ], 422);
        }

        $entry = $guestbook->entries()->create([
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
            'website' => $request->input('website'),
            'approved' => !$guestbook->requires_approval,
        ]);
        $guestbook->user->notify(new GuestbookEntryNotification($entry));

        // this is a really stupid hack. TODO: fix this. There's no reason to return an actual redirect here, just make it JSON
        if(!response('no_redirect')) {
            return redirect()
            ->route('embed.entries.index', ["guestbook" => $guestbook])->with('success','Entry created sucessfully');
        } else {
            return response()->json([
                'submitted' => true
            ]);
        }
    }
}
