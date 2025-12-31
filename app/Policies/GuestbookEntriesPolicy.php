<?php

namespace App\Policies;

use App\Models\GuestbookEntries;
use App\Models\User;
class GuestbookEntriesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasRole("admin")) {
            return true;
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GuestbookEntries $guestbookEntries): bool
    {
        if($user->hasRole("admin")) {
            return true;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasRole("admin")) {
            return true;
        }

        return true; //TODO: change this when we implement per-guestbook bans
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GuestbookEntries $guestbookEntries): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GuestbookEntries $guestbookEntry): bool
    {
        if($user->hasRole("admin")) {
            return true;
        }

        return $guestbookEntry->guestbook->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GuestbookEntries $guestbookEntries): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GuestbookEntries $guestbookEntries): bool
    {
        return false;
    }

    public function approve(User $user, GuestbookEntries $guestbookEntry): bool {
        return $guestbookEntry->guestbook->user_id === $user->id;
    }
}
