<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function show(Request $request){
        return view('admin.invite');
    }

    public function create(){

    }
}
