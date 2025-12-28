<?php

namespace App\Helpers;
use App\Models\Guestbook;
class GuestbookExportHelper {
    public static function getData(Guestbook $guestbook)
    {
        $entries = $guestbook->entries()
            ->latest()
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
}