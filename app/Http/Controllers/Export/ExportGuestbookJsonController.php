<?php

namespace App\Http\Controllers\Export;

use App\Helpers\GuestbookExportHelper;
use App\Models\Guestbook;
use Illuminate\Http\Request;
use Response;

class ExportGuestbookJsonController extends \App\Http\Controllers\Controller {
    public function exportRaw(Request $request, Guestbook $guestbook) {
        return response()->json(GuestbookExportHelper::getData($guestbook, true));
    }

    public function exportEntriesForApi(Request $request, Guestbook $guestbook) {
        $data = GuestbookExportHelper::getData($guestbook, false);
        $entries = $data["guestbooks"][$guestbook->id]["entries"];
        foreach ($entries as $key => $entry) {
            $options = config('markdown.commonmark_options');
            $renderer = new \App\Renderers\MDSandboxRenderer($options);

            $entries[$key]['rendered_comment'] = (string) $renderer->convertToHtml($entry['comment']);
        }

        return response()->json($entries);
    }

    public function exportGuestbookForApi(Request $request, Guestbook $guestbook) {
        return response()->json(GuestbookExportHelper::getData($guestbook, false));
    }
    public function export(Request $request, Guestbook $guestbook) {
        $data = GuestbookExportHelper::getData($guestbook, true);
    
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