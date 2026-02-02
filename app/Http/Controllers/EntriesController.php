<?php

namespace App\Http\Controllers;

use App\Helpers\UserBanHelper;
use App\Models\Guestbook;
use App\Models\GuestbookEntries;
use App\Notifications\GuestbookEntryNotification;
use Illuminate\Http\Request;
use Validator;

class EntriesController extends Controller
{
    public function create(Request $request, Guestbook $guestbook)
    {
        // Pass the guestbook to the view
        return view('entries.create', compact('guestbook'));
    }

    public function store(Request $request, Guestbook $guestbook)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'comment' => 'required|max:20000',
            'website' => 'nullable|url',
            'captcha' => 'required',
            'posted_at' => 'date|before_or_equal:now',
            'captcha_type' => 'required|string'
        ]);

        $validator->after(function ($validator) use ($request) {
            if (! $this->captcha_validate($request)) {
                $validator->errors()->add('captcha', 'The captcha is invalid.');
            }
        });
        $validated = $validator->validate();

        if (! optional(auth()->user())->can('update', $guestbook)) {
            unset($validated['posted_at']); // ignore any value from guest
        }
        
        $entry = $guestbook->entries()->create(array_merge(
            $validated,
            [
                'approved' => ! $guestbook->requires_approval,
            ]
        ));

        $guestbook->user->notify(new GuestbookEntryNotification($entry));

        return redirect()->route('entries.index', ["guestbook" => $guestbook])->with('success','Entry created sucessfully');
    }

    public function index(Request $request, Guestbook $guestbook) {
        $guestbookAdmin = $guestbook->user()->first();
        if(UserBanHelper::isBanned($guestbookAdmin)) {
            return view('guestbooks.adminIsBanned');
        }

        $entries = $guestbook->entries()
            ->where('approved', true)
            ->latest('posted_at')
            ->get();
        
        return view('entries.index', ['entries' => $entries, 'guestbook' => $guestbook, 'is_embed' => false]);
    }

    public function edit(Request $request, Guestbook $guestbook) {
        $entries = $guestbook->entries()->orderBy('created_at', 'desc')->get();
        return view("entries.edit", ["entries" => $entries, "guestbook"=> $guestbook]);
    }

    public function editAll(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        $perPage = min(
            (int) $request->query('per_page', 10),
            50
        );
        
        if($request->user()->hasRole('admin')) {
            $entries = GuestbookEntries::query()
                ->search($request->query('search'))
                ->latest()
                ->paginate($perPage)
                ->withQueryString();
        } else {
            $entries = GuestbookEntries::query()
                ->ownedBy($request->user())
                ->search($request->query('search'))
                ->latest('posted_at')
                ->paginate($perPage)
                ->withQueryString();
        }


        return view('entries.editAll', compact('entries'));
    }
    public function destroy(GuestbookEntries $entry)
    {
        $entry->delete();

        return redirect()
            ->back()
            ->with('status', 'Entry deleted');
    }

    public function approve(GuestbookEntries $entry) {
        if($entry->approved === false) {
            $entry->approved = true;
        }
        $entry->save();

        return back()->with('success', 'Entry approved!');
    }

    private function captcha_validate($request) {
        $type = $request->input('captcha_type');

        if($type === 'image') {
            return $this->captcha_image_validate($request);
        }

        if($type === 'audio') {
            return $this->captcha_audio_validate($request);
        }

        return false;
    }

    private function captcha_image_validate(Request $request): bool {
        return validator(
            $request->only('captcha'),
            ['captcha' => ['required', 'captcha']]
        )->passes();
    }

    private function captcha_audio_validate($request) {

    }
}
