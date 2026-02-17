<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;

class WarehousePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'warehouse_staff', 'receiver']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Warehouse $warehouse): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users can view all warehouses to support transfer workflows
        return $user->hasAnyRole(['warehouse_staff', 'receiver']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Warehouse $warehouse): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        // Warehouse staff can update their own warehouse
        return $user->hasRole('warehouse_staff') && $user->warehouse_id === $warehouse->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Warehouse $warehouse): bool
    {
        if ($warehouse->is_main) {
            return false;
        }

        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Warehouse $warehouse): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Warehouse $warehouse): bool
    {
        if ($warehouse->is_main) {
            return false;
        }

        return $user->hasRole('admin');
    }
}
