<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function showDeleteForm()
    {
        return view('account.delete');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        $user = Auth::user();

        // Log out the user before deleting
        Auth::logout();

        // Delete the user
        $user->delete();

        // Redirect to homepage with a success message
        return redirect('/')->with('status', 'Your account has been permanently deleted.');
    }
}
