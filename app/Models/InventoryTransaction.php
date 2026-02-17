<?php

namespace App\Models;

use App\Enums\InventoryTransactionStatus;
use App\Enums\InventoryTransactionType;
use App\Enums\TransactionApprovalRole;
use App\Enums\TransactionApprovalStatus;
use App\Observers\InventoryTransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

#[ObservedBy(InventoryTransactionObserver::class)]
class InventoryTransaction extends Model
{
    use HasFactory, HasUuids;

    /**
     * Type-specific business rules.
     * Each type defines which warehouses are required and which approval role handles it.
     */
    public const TYPE_RULES = [
        'transfer' => [
            'requires_from_warehouse' => true,
            'requires_to_warehouse' => true,
            'requires_distribution_area' => false,
            'decrements_source' => true,
            'increments_destination' => true,
            'approval_role' => 'receiver',
        ],
        'return' => [
            'requires_from_warehouse' => true,
            'requires_to_warehouse' => true,
            'requires_distribution_area' => false,
            'decrements_source' => true,
            'increments_destination' => true,
            'approval_role' => 'warehouse_manager',
        ],
        'waste' => [
            'requires_from_warehouse' => true,
            'requires_to_warehouse' => false,
            'requires_distribution_area' => false,
            'decrements_source' => true,
            'increments_destination' => false,
            'approval_role' => 'compliance_officer',
        ],
        'distribution' => [
            'requires_from_warehouse' => true,
            'requires_to_warehouse' => false,
            'requires_distribution_area' => true,
            'decrements_source' => true,
            'increments_destination' => false,
            'approval_role' => 'compliance_officer',
        ],
        'adjustment' => [
            'requires_from_warehouse' => false,  // Only for negative adjustments
            'requires_to_warehouse' => false,
            'requires_distribution_area' => false,
            'decrements_source' => false,  // Depends on sign
            'increments_destination' => false,  // Depends on sign
            'approval_role' => 'admin',
        ],
    ];

    protected $fillable = [
        'type',
        'from_warehouse_id',
        'to_warehouse_id',
        'product_id',
        'distribution_area_id',
        'raw_material_id',
        'batch_id',
        'quantity',
        'actual_quantity_received',
        'status',
        'initiated_by',
        'notes',
        'transaction_date',
        'completed_at',
        'completed_by',
        'rejected_at',
        'rejected_by',
    ];

    protected $casts = [
        'type' => InventoryTransactionType::class,
        'status' => InventoryTransactionStatus::class,
        'quantity' => 'decimal:2',
        'actual_quantity_received' => 'decimal:2',
        'transaction_date' => 'timestamp',
        'completed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->status)) {
                $model->status = InventoryTransactionStatus::Draft;
            }
            if (empty($model->transaction_date)) {
                $model->transaction_date = now();
            }
            if (empty($model->initiated_by)) {
                $model->initiated_by = auth()->id();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function transactionApprovals(): HasMany
    {
        return $this->hasMany(TransactionApproval::class, 'transaction_id');
    }

    public function latestApproval(): HasOne
    {
        return $this->hasOne(TransactionApproval::class, 'transaction_id')->latestOfMany();
    }

    public function distributionRecords(): HasMany
    {
        return $this->hasMany(DistributionRecord::class, 'transaction_id');
    }

    public function distributionArea(): BelongsTo
    {
        return $this->belongsTo(DistributionArea::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the type-specific rules for this transaction.
     */
    public function typeRules(): array
    {
        $typeValue = $this->type instanceof InventoryTransactionType
            ? $this->type->value
            : $this->type;

        return self::TYPE_RULES[$typeValue] ?? [];
    }

    /**
     * Check if there is a quantity variance between expected and actual.
     */
    public function hasVariance(): bool
    {
        return $this->actual_quantity_received !== null
            && (float) $this->actual_quantity_received !== (float) $this->quantity;
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Determine if a given user can approve this transaction.
     * Checks: transaction is pending, user has the required role, and user is not the initiator.
     */
    public function canBeApprovedBy(User $user): bool
    {
        if ($this->status !== InventoryTransactionStatus::PendingApproval) {
            return false;
        }

        // Initiator cannot approve their own transaction
        if ($this->initiated_by === $user->id) {
            return false;
        }

        // Admin can approve everything
        if ($user->hasRole('admin')) {
            return true;
        }

        $rules = $this->typeRules();
        $requiredRole = $rules['approval_role'] ?? null;

        if (! $requiredRole) {
            return false;
        }

        // Map approval roles to Spatie permission roles
        $roleMap = [
            'receiver' => 'receiver',
            'warehouse_manager' => 'warehouse_staff',
            'compliance_officer' => 'compliance_officer',
            'admin' => 'admin',
        ];

        $spatieRole = $roleMap[$requiredRole] ?? $requiredRole;

        return $user->hasRole($spatieRole);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Validate that stock exists at source warehouse before transaction.
     * Uses pessimistic locking to prevent race conditions.
     */
    public function validateStockAvailability(?float $quantity = null): void
    {
        $qty = $quantity ?? $this->quantity;

        // No checks for positive Adjustments (they add stock)
        if ($this->type === InventoryTransactionType::Adjustment && $qty > 0) {
            return;
        }

        $warehouseId = $this->from_warehouse_id;

        if (! $warehouseId) {
            if ($this->type === InventoryTransactionType::Adjustment && $qty < 0) {
                throw ValidationException::withMessages([
                    'from_warehouse_id' => __('inventory_transaction.messages.source_warehouse_required'),
                ]);
            }

            return;
        }

        $query = ProductStock::where('product_id', $this->product_id)
            ->where('warehouse_id', $warehouseId);

        if ($this->batch_id) {
            $query->where('batch_id', $this->batch_id);
        }

        // Pessimistic lock
        $stock = $query->lockForUpdate()->first();

        $available = $stock?->quantity ?? 0;

        if ($available < abs($qty)) {
            throw ValidationException::withMessages([
                'quantity' => __('inventory_transaction.messages.insufficient_stock', [
                    'available' => $available,
                ]),
            ]);
        }
    }

    /**
     * Execute the stock adjustment (decrement source, increment destination).
     * Supports partial receipts via $actualQuantity parameter.
     */
    public function executeStockAdjustment(?float $actualQuantity = null, ?User $completedBy = null): void
    {
        DB::transaction(function () use ($actualQuantity, $completedBy) {
            $effectiveQuantity = $actualQuantity ?? $this->quantity;
            $rules = $this->typeRules();

            $this->validateStockAvailability($effectiveQuantity);

            // 1. Decrement from Source
            if ($this->from_warehouse_id && ($rules['decrements_source'] ?? false)) {
                $this->decrementStock($this->from_warehouse_id, $effectiveQuantity);
            }

            // 2. Increment at Destination (transfers/returns)
            if ($this->to_warehouse_id && ($rules['increments_destination'] ?? false)) {
                // For partial receipts, increment by actual quantity received
                $incrementQty = $actualQuantity ?? $effectiveQuantity;
                $this->incrementStock($this->to_warehouse_id, $incrementQty);
            }

            // 3. Handle Distribution Record
            if ($this->type === InventoryTransactionType::Distribution) {
                $this->createDistributionRecord($effectiveQuantity);
            }

            // 4. Mark as Completed
            $this->update([
                'status' => InventoryTransactionStatus::Completed,
                'actual_quantity_received' => $actualQuantity,
                'completed_at' => now(),
                'completed_by' => $completedBy?->id ?? auth()->id(),
            ]);

            Log::info('Transaction completed', [
                'transaction_id' => $this->id,
                'type' => $this->type->value,
                'quantity' => $this->quantity,
                'actual_quantity' => $actualQuantity,
                'completed_by' => $completedBy?->id ?? auth()->id(),
            ]);
        });
    }

    /**
     * Reject this transaction with a mandatory reason.
     */
    public function reject(string $reason, ?User $rejectedBy = null): void
    {
        $user = $rejectedBy ?? auth()->user();

        $this->update([
            'status' => InventoryTransactionStatus::Rejected,
            'rejected_at' => now(),
            'rejected_by' => $user?->id,
            'notes' => $this->notes
                ? $this->notes . "\n\n---\n**Rejection Reason:** " . $reason
                : "**Rejection Reason:** " . $reason,
        ]);

        // Create approval record for the rejection
        $this->transactionApprovals()->create([
            'user_id' => $user?->id,
            'role' => TransactionApprovalRole::from($this->typeRules()['approval_role'] ?? 'admin'),
            'status' => TransactionApprovalStatus::Rejected,
            'comments' => $reason,
        ]);

        Log::info('Transaction rejected', [
            'transaction_id' => $this->id,
            'rejected_by' => $user?->id,
            'reason' => $reason,
        ]);
    }

    /**
     * Legacy alias — calls executeStockAdjustment for backward compat.
     */
    public function executeTransaction(): void
    {
        $this->executeStockAdjustment();
    }

    protected function decrementStock(string $warehouseId, ?float $quantity = null): void
    {
        $qty = $quantity ?? $this->quantity;

        $stock = ProductStock::firstOrCreate([
            'product_id' => $this->product_id,
            'warehouse_id' => $warehouseId,
            'batch_id' => $this->batch_id,
        ], ['quantity' => 0]);

        $stock->decrement('quantity', abs($qty));
    }

    protected function incrementStock(string $warehouseId, ?float $quantity = null): void
    {
        $qty = $quantity ?? $this->quantity;

        $stock = ProductStock::firstOrCreate([
            'product_id' => $this->product_id,
            'warehouse_id' => $warehouseId,
            'batch_id' => $this->batch_id,
        ], ['quantity' => 0]);

        $stock->increment('quantity', abs($qty));
    }

    protected function createDistributionRecord(?float $quantity = null): void
    {
        // Prevent duplicate records
        if ($this->distributionRecords()->exists()) {
            return;
        }

        $this->distributionRecords()->create([
            'distribution_area_id' => $this->distribution_area_id,
            'product_id' => $this->product_id,
            'batch_id' => $this->batch_id,
            'quantity' => $quantity ?? $this->quantity,
            'beneficiaries_served' => (int) ($quantity ?? $this->quantity),
            'distributed_at' => now(),
            'notes' => $this->notes,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', InventoryTransactionStatus::PendingApproval);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', InventoryTransactionStatus::Completed);
    }

    public function scopeForWarehouse($query, string $warehouseId)
    {
        return $query->where(function ($q) use ($warehouseId) {
            $q->where('from_warehouse_id', $warehouseId)
              ->orWhere('to_warehouse_id', $warehouseId);
        });
    }

    public function scopeWithVariance($query)
    {
        return $query->whereNotNull('actual_quantity_received')
            ->whereColumn('actual_quantity_received', '!=', 'quantity');
    }
}
