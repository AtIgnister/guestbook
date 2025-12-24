<?php

namespace App\Http\Controllers\Export;

use App\Models\Guestbook;
use Illuminate\Http\Request;

class ExportGuestbookListController extends \App\Http\Controllers\Controller {
    public function index(Request $request) {
        $guestbooks = Guestbook::where("user_id", \Auth::id())->get();
        return view("export.exportTable", ["guestbooks" => $guestbooks]);
    }
}