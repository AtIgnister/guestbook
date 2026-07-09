<?php

namespace App\Helpers;
use App\Models\Guestbook;

class GuestbookExportHelper {
    
    public static function getData(Guestbook $guestbook, bool $isExport = false, bool $repliesAsToplevel = false)
    {
        if(!$isExport) {
            $entries = $guestbook->getAllVisibleToplevelEntries();
        } else {
            if(!$repliesAsToplevel) {
            $entries = $guestbook->entries()
                    ->where('is_reply', false)
                    ->latest('posted_at')
                    ->get();
            } else {
                $entries = $guestbook->entries()
                    ->latest('posted_at')
                    ->get();
            }

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
                    'description' => $guestbook->description,
                    'style'   => $guestbook->style,
                    'entries' => $entries,
                    'author_name' => $guestbook->author_name
                ],
            ],
        ];
    }
}