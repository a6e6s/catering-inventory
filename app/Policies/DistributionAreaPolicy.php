<?php

namespace App\Policies;

use App\Models\DistributionArea;
use App\Models\User;

class DistributionAreaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') 
            || $user->hasRole('warehouse_staff');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DistributionArea $distributionArea): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('warehouse_staff') && $user->warehouse_id) {
            return $distributionArea->warehouses()->where('warehouses.id', $user->warehouse_id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('warehouse_staff');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DistributionArea $distributionArea): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('warehouse_staff') && $user->warehouse_id) {
             return $distributionArea->warehouses()->where('warehouses.id', $user->warehouse_id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DistributionArea $distributionArea): bool
    {
        // Prevent deletion if has history
        if ($distributionArea->distributionRecords()->exists()) {
             return false;
        }

        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DistributionArea $distributionArea): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DistributionArea $distributionArea): bool
    {
        if ($distributionArea->distributionRecords()->exists()) {
             return false;
        }

        return $user->hasRole('admin');
    }
}
