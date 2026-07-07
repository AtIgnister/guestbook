<?php

namespace App\Helpers;
use App\Models\Guestbook;
use App\Models\GuestbookEntries;

class GuestbookExportHelper {
    public static function getData(Guestbook $guestbook, bool $isExport = false)
    {
        if(!$isExport) {
            $entries = $guestbook->getAllVisibleToplevelEntries();
        } else {
            $entries = $guestbook->entries()
                ->where('is_reply', false)
                ->latest('posted_at')
                ->get();
        }

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