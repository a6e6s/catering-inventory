<?php

namespace App\Policies;

use App\Models\TransactionApproval;
use App\Models\User;

class TransactionApprovalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_transaction::approval');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TransactionApproval $transactionApproval): bool
    {
        return $user->can('view_transaction::approval');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false; // Approvals are auto-created by the system
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TransactionApproval $transactionApproval): bool
    {
        return $user->can('update_transaction::approval');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TransactionApproval $transactionApproval): bool
    {
        return $user->can('delete_transaction::approval');
    }

    /**
     * Determine whether the user can approve the transaction.
     */
    public function approve(User $user, TransactionApproval $transactionApproval): bool
    {
        if ($transactionApproval->status !== \App\Enums\TransactionApprovalStatus::Pending) {
            return false;
        }

        // Logic to check if user has the correct role for this approval
        // e.g., if $transactionApproval->approver_role === Receiver, user needs receiver role
        
        // For simplicity/demo conform to basic perm + role check or ID check if assigned
        if ($transactionApproval->approver_id && $transactionApproval->approver_id !== $user->id) {
            return false;
        }

        return $user->can('approve_transaction::approval');
    }

    /**
     * Determine whether the user can reject the transaction.
     */
    public function reject(User $user, TransactionApproval $transactionApproval): bool
    {
        if ($transactionApproval->status !== \App\Enums\TransactionApprovalStatus::Pending) {
            return false;
        }

        if ($transactionApproval->approver_id && $transactionApproval->approver_id !== $user->id) {
            return false;
        }

        return $user->can('reject_transaction::approval');
    }
}
