<?php

namespace App\Http\Controllers\Export;

use App\Helpers\GuestbookExportHelper;
use App\Models\Guestbook;
use Illuminate\Http\Request;
use Response;

class ExportGuestbookHTMLController extends \App\Http\Controllers\Controller {
    public function exportRaw(Request $request, Guestbook $guestbook) {
        return view("export.htmlExport", ["guestbooks" => [$guestbook]]);
    }

    public function export(Request $request, Guestbook $guestbook) {
        $content = view("export.htmlExport", ["guestbooks" => [$guestbook]])->render();
        return response()->streamDownload(function() use ($content) {
            echo $content;
        }, 'guestbook.html');
    }
}