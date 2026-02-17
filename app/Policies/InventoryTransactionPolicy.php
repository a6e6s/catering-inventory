<?php

namespace App\Policies;

use App\Enums\InventoryTransactionStatus;
use App\Models\InventoryTransaction;
use App\Models\User;

class InventoryTransactionPolicy
{
    /**
     * All authenticated users can view the list (scoping handles filtering).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'warehouse_staff', 'receiver', 'compliance_officer']);
    }

    /**
     * Admin sees all. Others see transactions related to their warehouses.
     */
    public function view(User $user, InventoryTransaction $transaction): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        // Initiator can always view their own
        if ($transaction->initiated_by === $user->id) {
            return true;
        }

        // Warehouse staff can see transactions involving their warehouse
        if ($user->hasRole('warehouse_staff')) {
            $userWarehouseIds = $user->warehouses?->pluck('id')->toArray() ?? [];

            return in_array($transaction->from_warehouse_id, $userWarehouseIds)
                || in_array($transaction->to_warehouse_id, $userWarehouseIds);
        }

        // Receivers can see transactions directed to their warehouse
        if ($user->hasRole('receiver')) {
            $userWarehouseIds = $user->warehouses?->pluck('id')->toArray() ?? [];

            return in_array($transaction->to_warehouse_id, $userWarehouseIds);
        }

        // Compliance officers see waste and distribution
        if ($user->hasRole('compliance_officer')) {
            return in_array($transaction->type->value, ['waste', 'distribution']);
        }

        return false;
    }

    /**
     * Admin and warehouse_staff can create transactions.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'warehouse_staff']);
    }

    /**
     * Only draft transactions can be edited — by creator or admin.
     */
    public function update(User $user, InventoryTransaction $transaction): bool
    {
        if ($transaction->status !== InventoryTransactionStatus::Draft) {
            return false;
        }

        return $user->hasRole('admin') || $transaction->initiated_by === $user->id;
    }

    /**
     * Only draft transactions can be deleted — by creator or admin.
     */
    public function delete(User $user, InventoryTransaction $transaction): bool
    {
        if ($transaction->status !== InventoryTransactionStatus::Draft) {
            return false;
        }

        return $user->hasRole('admin') || $transaction->initiated_by === $user->id;
    }

    /**
     * Delegation to model method for approval authorization.
     */
    public function approve(User $user, InventoryTransaction $transaction): bool
    {
        return $transaction->canBeApprovedBy($user);
    }
}
