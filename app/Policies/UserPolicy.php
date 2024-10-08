<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $modal): bool
    {

        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $modal): bool
    {

        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $modal): bool
    {

        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $modal): bool
    {

        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $modal): bool
    {

        return $user->hasRole(['Admin Dinkop','Admin Koperasi']);
    }
}
