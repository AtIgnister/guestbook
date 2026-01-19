<?php

namespace App\Policies;

use App\Models\GuestbookEntries;
use App\Models\User;
use App\Models\IpBan;

class IpBanPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, IpBan $ipBan = null): bool
    {
        // Admins can always create
        if ($user->hasRole('admin')) {
            return true;
        }

        // Local bans require an IpBan instance
        return $ipBan
            && $ipBan->guestbook
            && $user->id === $ipBan->guestbook->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, IpBan $ipBan): bool
    {
        if($ipBan->is_global) {
            return $user->hasRole("admin");
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, IpBan $ipBan): bool
    {
        if($ipBan->is_global) {
            return $user->hasRole("admin");
        }

        return $ipBan->guestbook
            && $user->id === $ipBan->guestbook->user_id;
    }

}
