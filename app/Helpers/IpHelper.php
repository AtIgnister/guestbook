<?php
namespace App\Helpers;

use App\Models\Guestbook;
use App\Models\IpBan;
use Illuminate\Support\Facades\Request;

class IpHelper {
    public static function ipHash(string $ip): string
    {
        return hash_hmac(
            'sha256',
            inet_pton($ip),
            config('app.key'),
            true
        );
    }

    public static function isBanned(Request $request, IpBan $ipBan, ?Guestbook $guestbook) {
        if ($request->ip() !== $ipBan->guestbookEntryIp) {
            return false;
        }

        if ($ipBan->is_global) {
            return true;
        }

        return $guestbook !== null
            && $ipBan->guestbook !== null
            && $guestbook->id === $ipBan->guestbook->id;
        }
}