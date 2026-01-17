<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBan;
use Illuminate\Http\Request;

class userBanController extends Controller
{
    public function create(Request $request, User $user) {
        return view('users.createBan', compact('user'));
    }

    public function store(Request $request, User $user) {
        $authUser = $request->user();

        if ($authUser->cannot('create', UserBan::class)) {
            abort(403);
        }

        if ($user->userBan()->exists()) {
            return back()->withErrors(['ban_error' => 'User is already banned.']);
        }

        $user->userBan()->create([
            'banned_by' => $authUser->id,
        ]);

        return redirect()
            ->route('guestbooks.index')
            ->with('success', 'User banned successfully.');
    }
}
