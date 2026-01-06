<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Notifications\UserInvited;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function show(){
        return view('admin.invite');
    }

    public function create(Request $request){

        $validated = $request->validate([
            'email' =>'required|string|email|max:255|unique:users',
            'role' => 'required'
        ]);
        
        $userRole = $validated['role'];
        $email = $validated['email'];
        try
        {
            Notification::route('mail', $email)->notify(new UserInvited($userRole, $request->user())); 
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('error','<b>Error!</b> Try again later');
        }

        return redirect()->route('dashboard')->with('success',"<b>Success!</b> An invite with level {$validated['role']} has been sent to $email");
    }
}
