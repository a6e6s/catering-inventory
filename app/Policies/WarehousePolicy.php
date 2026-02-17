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
        return true; // All authenticated users can see the list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Warehouse $warehouse): bool
    {
        // Admin can view all
        if ($user->role === 'admin') {
            return true;
        }

        // Users can only view their assigned warehouse or if they have permission
        // For now, let's allow viewing all to support transfer workflows
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Warehouse $warehouse): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        // Warehouse managers can update their own warehouse
        return $user->role === 'warehouse_manager' && $user->warehouse_id === $warehouse->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Warehouse $warehouse): bool
    {
        // Main warehouse cannot be deleted (enforced in model too, but good to have here)
        if ($warehouse->is_main) {
            return false;
        }

        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Warehouse $warehouse): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Warehouse $warehouse): bool
    {
        if ($warehouse->is_main) {
            return false;
        }

        return $user->role === 'admin';
    }
}
