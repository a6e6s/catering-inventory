<?php

namespace App\Observers;

use App\Enums\InventoryTransactionStatus;
use App\Enums\TransactionApprovalRole;
use App\Enums\TransactionApprovalStatus;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Log;

class InventoryTransactionObserver
{
    /**
     * Handle the "created" event.
     * Auto-create initial approval step when a transaction is submitted.
     */
    public function updated(InventoryTransaction $transaction): void
    {
        // When status changes to PendingApproval, create the first approval step
        if ($transaction->isDirty('status')
            && $transaction->status === InventoryTransactionStatus::PendingApproval
        ) {
            $this->createInitialApprovalStep($transaction);
        }
    }

    /**
     * Create the initial approval record for the transaction.
     */
    protected function createInitialApprovalStep(InventoryTransaction $transaction): void
    {
        // Skip if approval already exists for this transaction
        if ($transaction->transactionApprovals()->exists()) {
            return;
        }

        $rules = $transaction->typeRules();
        $approvalRole = $rules['approval_role'] ?? 'admin';

        $transaction->transactionApprovals()->create([
            'step' => 1,
            'role' => TransactionApprovalRole::from($approvalRole),
            'status' => TransactionApprovalStatus::Pending,
            'comments' => null,
            'user_id' => null, // Will be set when someone claims/approves
        ]);

        Log::info('Approval step created', [
            'transaction_id' => $transaction->id,
            'type' => $transaction->type->value,
            'approval_role' => $approvalRole,
        ]);
    }
}
