<?php
namespace App\Helpers;

use App\Models\Guestbook;
use App\Models\IpBan;
use Illuminate\Http\Request;

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

    public static function isBanned(Request $request, ?Guestbook $guestbook): bool {
        $ipHash = self::ipHash($request->ip());

        return IpBan::query()
            ->whereHas('guestbookEntryIp', function ($query) use ($ipHash) {
                $query->where('ip_hash', $ipHash);
            })
            ->where(function ($query) use ($guestbook) {
                $query->where('is_global', true);

                if ($guestbook) {
                    $query->orWhere('guestbook_id', $guestbook->id);
                }
            })
            ->exists();
    }

    public static function isBannedByIpHash($entry, $guestbook) {
        $ipHash = $entry->ip->ip_hash;

        return IpBan::query()
            ->whereHas('guestbookEntryIp', function ($query) use ($ipHash) {
                $query->where('ip_hash', $ipHash);
            })
            ->where(function ($query) use ($guestbook) {
                $query->where('is_global', true);

                if ($guestbook) {
                    $query->orWhere('guestbook_id', $guestbook->id);
                }
            })
            ->exists();
    }
}