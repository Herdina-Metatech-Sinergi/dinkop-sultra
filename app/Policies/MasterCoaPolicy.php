<?php

namespace App\Policies;

use App\Models\MasterCoa;
use App\Models\User;

class MasterCoaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin Dinkop']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MasterCoa $modal): bool
    {

        return $user->hasRole(['Admin Dinkop']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return $user->hasRole(['Admin Dinkop']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MasterCoa $modal): bool
    {

        return $user->hasRole(['Admin Dinkop']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MasterCoa $modal): bool
    {

        return $user->hasRole(['Admin Dinkop']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MasterCoa $modal): bool
    {

        return $user->hasRole(['Admin Dinkop']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MasterCoa $modal): bool
    {

        return $user->hasRole(['Admin Dinkop']);
    }
}
