<?php

namespace App\Policies;

use App\Models\Seeker;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeekerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Seeker $seeker)
    {
        return $user->hasRole(['admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasRole(['admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Seeker $seeker)
    {
        return $user->hasRole(['admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Seeker $seeker)
    {
        return $user->hasRole(['admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Seeker $seeker)
    {
        return $user->hasRole(['admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Seeker $seeker)
    {
        return $user->hasRole(['admin']);
    }
}
