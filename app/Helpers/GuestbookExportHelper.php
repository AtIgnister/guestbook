<?php

namespace App\Helpers;
use App\Models\Guestbook;
use App\Models\GuestbookEntries;

class GuestbookExportHelper {
    public static function getData(Guestbook $guestbook)
    {
        $entries = $guestbook->getAllVisibleToplevelEntries();

        if($entries) {
            foreach ($entries as $entry) {
                $entry->setRelation('replies', $entry->replies);
            }
        }

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