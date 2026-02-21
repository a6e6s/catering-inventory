<?php

namespace App\Policies;

use App\Models\ProductStock;
use App\Models\User;

class ProductStockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'warehouse_staff']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductStock $productStock): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        // Warehouse staff can only view stock in their warehouse
        if ($user->hasRole('warehouse_staff') && $user->warehouse_id) {
            return $productStock->warehouse_id === $user->warehouse_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Stock is managed via transactions
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductStock $productStock): bool
    {
        return false; // Stock is managed via transactions
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductStock $productStock): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductStock $productStock): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductStock $productStock): bool
    {
        return false;
    }
}
