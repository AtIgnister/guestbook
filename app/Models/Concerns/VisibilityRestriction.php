<?php
namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

trait VisibilityRestriction
{
    /**
     * Changes visibility of returned data based on user type.
     * Admins can see everything, regular users can only see models they created themselves
     */
    public function ScopeVisibilityRestriction(Builder $query, ?User $user): Builder
    {
        if ($user?->hasRole('admin')) {
            return $query;
        }

        return $query->where(
            $this->getTable() . '.user_id',
            $user->id
        );
    }
}
