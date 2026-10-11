<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;
use App\Notifications\UserInvited;
use Illuminate\Http\Request;
use App\Models\Invite;
use Exception;

class InviteController extends Controller
{
    public function show(){
        return view('admin.invite');
    }

    public function create(Request $request)
    {
        if (Auth::user()->cannot('create', Invite::class)) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
        ]);

        $userRole = $validated['role'];
        $email = $validated['email'];

        try {
            DB::transaction(function () use (
                $userRole,
                $email,
                $request
            ) {
                $invite = Invite::create([
                    'email' => $email,
                    'role' => $userRole,
                ]);

                Notification::route('mail', $email)
                    ->notify(
                        new UserInvited(
                            $userRole,
                            $request->user(),
                            $invite
                        )
                    );
            });
        } catch (Exception $e) {
            return redirect()
                ->route('dashboard')
                ->with('error', '<b>Error!</b> Try again later');
        }

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                "<b>Success!</b> An invite with level {$userRole} has been sent to $email"
            );
    }
}
