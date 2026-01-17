<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBan;
use Illuminate\Http\Request;

class UserBanController extends Controller
{
    public function create(Request $request, User $user) {
        $authUser = $request->user();
        if ($authUser->cannot('create', UserBan::class)) {
            abort(403);
        }

        return view('users.createBan', compact('user'));
    }

    public function destroy(Request $request, UserBan $userBan) {
        $authUser = $request->user();
        if ($authUser->cannot('delete', $userBan)) {
            abort(403);
        }

        $userBan->delete();
        return redirect()->route('users.index')->with('success','User unbanned successfully.');
    }

    public function delete(Request $request, UserBan $userBan) {
        $authUser = $request->user();
        if ($authUser->cannot('delete', $userBan)) {
            abort(403);
        }

        return view('users.deleteBan', compact('userBan'));
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
            ->route('users.index')
            ->with('success', 'User banned successfully.');
    }
}
