<?php

namespace App\Http\Controllers\Export;

use App\Helpers\GuestbookExportHelper;
use App\Models\Guestbook;
use Illuminate\Http\Request;
use Response;

class ExportGuestbookJsonController extends \App\Http\Controllers\Controller {
    public function exportRaw(Request $request, Guestbook $guestbook) {
        return response()->json(GuestbookExportHelper::getData($guestbook));
    }

    public function export(Request $request, Guestbook $guestbook) {
        $data = GuestbookExportHelper::getData($guestbook);
    
        $json = json_encode($data, JSON_PRETTY_PRINT);
    
        return Response::streamDownload(
            function () use ($json) {
                echo $json;
            },
            'data.json',
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}