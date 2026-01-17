<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userBanController extends Controller
{
    public function create(Request $request, User $user) {
        return view('users.createBan', compact('user'));
    }

    public function store(Request $request, User $user) {
        
    }
}
