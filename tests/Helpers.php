<?php

use App\Models\GuestbookEntryIp;
use App\Models\User;
use App\Models\IpBan;

// Some custom helper functions we want available in all of our test cases.

/**
 * Create a user with a specific role.
 *
 * @param string $role
 * @return User
 */
function userWithRole(string $role): User
{
    $user = User::factory()->create();
    $user->assignRole($role);

    return $user;
}

function standaloneGuestbook(): \App\Models\Guestbook
{
    return \App\Models\Guestbook::factory()->create([
        'user_id' => userWithRole('user')->id,
    ]);
}

function sampleIP($seed = 1): GuestbookEntryIp
{
    $hash = md5($seed);
    $ip = long2ip(hexdec(substr($hash, 0, 8)));

    return new GuestbookEntryIp([
        'ip' => $ip,
        ''
    ]);
}

