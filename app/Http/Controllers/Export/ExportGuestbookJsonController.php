<?php

namespace App\Http\Controllers\Export;

use App\Models\Guestbook;
use Illuminate\Http\Request;
use Response;

class ExportGuestbookJsonController extends \App\Http\Controllers\Controller
{
    private function getData(Guestbook $guestbook)
    {
        $entries = $guestbook->entries()
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'guestbooks' => [
                $guestbook->id => [
                    'id'      => $guestbook->id,
                    'name'    => $guestbook->name,
                    'style'   => $guestbook->style,
                    'entries' => $entries,
                ],
            ],
        ];
    }

    public function exportRaw(Request $request, Guestbook $guestbook) {
        return response()->json($this->getData($guestbook));
    }

    public function export(Request $request, Guestbook $guestbook) {
        $data = $this->getData($guestbook);
    
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