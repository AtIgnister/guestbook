<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserInvited;
use Illuminate\Http\Request;
use App\Mail\InviteCreated;
use App\Models\Invite;

class InviteController extends Controller
{
    public function show(){
        return view('admin.invite');
    }

    public function create(Request $request){
        if (Auth::user()->cannot('create')) {
            abort(403);
        }


        $validated = $request->validate([
            'email' =>'required|string|email|max:255|unique:users',
            'role' => 'required'
        ]);
        
        $userRole = $validated['role'];
        $email = $validated['email'];
        try
        {
            $invite = Invite::create([
                'email' => $email,
                'role' => $userRole
            ]);
            
            Notification::route('mail', $email)->notify(new UserInvited($userRole, $request->user(),$invite)); 
            
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('error','<b>Error!</b> Try again later');
        }

        return redirect()->route('dashboard')->with('success',"<b>Success!</b> An invite with level {$validated['role']} has been sent to $email");
    }
}
