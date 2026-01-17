<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserBan;

class UserBanPolicy
{
     /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if($user->userBan()->exists()) {
            return false;
        }

        if($user->hasRole("admin")) {
            return true;
        }

        return $model->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->userBan()->exists()) {
            return false;
        }

        return $user->hasRole("admin");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserBan $model): bool
    {
        if($user->userBan()->exists()) {
            return false;
        }

        if($user->hasRole("admin")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserBan $model): bool
    {
        if($user->userBan()->exists()) {
            return false;
        }

        if($user->hasRole("admin")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserBan $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserBan $model): bool
    {
        return false;
    }
}
