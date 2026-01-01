<?php
namespace App\Helpers;

class IpHash {
    public static function ipHash(string $ip): string
    {
        return hash_hmac(
            'sha256',
            inet_pton($ip),
            config('app.key'),
            true
        );
    }
}