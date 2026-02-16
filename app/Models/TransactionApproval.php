<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionApproval extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'approver_role',
        'approver_id',
        'step',
        'status',
        'comments',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\TransactionApprovalStatus::class,
            'approver_role' => \App\Enums\TransactionApprovalRole::class,
            'approved_at' => 'timestamp',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(InventoryTransaction::class, 'transaction_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', \App\Enums\TransactionApprovalStatus::Pending);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', \App\Enums\TransactionApprovalStatus::Approved);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', \App\Enums\TransactionApprovalStatus::Rejected);
    }

    public function scopeMyApprovals($query, User $user)
    {
        return $query->where('approver_id', $user->id);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    public function approve(User $user, ?string $comments = null): void
    {
        if ($this->status !== \App\Enums\TransactionApprovalStatus::Pending) {
            return;
        }

        $this->update([
            'status' => \App\Enums\TransactionApprovalStatus::Approved,
            'approved_at' => now(),
            'approver_id' => $user->id, // Ensure approver is set to who actually approved
            'comments' => $comments,
        ]);

        // Trigger next step or complete transaction?
        // This logic might belong in an Observer or Service, but basically:
        // If this was the last step, finalize the transaction.
        // For now, let's assume the Transaction model listens to this or we call it explicitly.
    }

    public function reject(User $user, string $comments): void
    {
        if ($this->status !== \App\Enums\TransactionApprovalStatus::Pending) {
            return;
        }

        $this->update([
            'status' => \App\Enums\TransactionApprovalStatus::Rejected,
            'approved_at' => now(), // Decision time
            'approver_id' => $user->id,
            'comments' => $comments,
        ]);
        
        // Rejecting an approval step likely rejects the whole transaction
        $this->transaction->update(['status' => \App\Enums\InventoryTransactionStatus::Rejected]); // Assuming Enum exists
    }
}
