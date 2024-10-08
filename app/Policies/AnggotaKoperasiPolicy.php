<?php

namespace App\Policies;

use App\Models\AnggotaKoperasi;
use App\Models\User;

class AnggotaKoperasiPolicy
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
        return true;
        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AnggotaKoperasi $modal): bool
    {
        return true;

        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;

        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AnggotaKoperasi $modal): bool
    {
        return true;

        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AnggotaKoperasi $modal): bool
    {
        return true;

        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AnggotaKoperasi $modal): bool
    {
        return true;

        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AnggotaKoperasi $modal): bool
    {
        return true;

        return $user->hasRole(['Administrator', 'Front Office','Perawat', 'Beauticiant']);
    }
}
