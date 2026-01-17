<?php
namespace App\Helpers;

use App\Models\User;
use App\Models\UserBan;

class UserBanHelper {
    public static function isBanned(User $user): bool {
        return UserBan::query()
            ->where('user_id', $user->id) // check if a ban exists for this user
            ->exists();
    }
}