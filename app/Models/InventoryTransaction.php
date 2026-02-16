<?php

namespace App\Models;

use App\Enums\InventoryTransactionStatus;
use App\Enums\InventoryTransactionType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

class InventoryTransaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type',
        'from_warehouse_id',
        'to_warehouse_id',
        'product_id',
        'distribution_area_id',
        'raw_material_id', // Kept for future raw material transactions, though focus is ProductStock
        'batch_id',
        'quantity',
        'status',
        'initiated_by',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'type' => InventoryTransactionType::class,
        'status' => InventoryTransactionStatus::class,
        'quantity' => 'decimal:2',
        'transaction_date' => 'timestamp',
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

    public function transactionApprovals(): HasMany
    {
        return $this->hasMany(TransactionApproval::class, 'transaction_id');
    }

    public function distributionRecords(): HasMany
    {
        return $this->hasMany(DistributionRecord::class, 'transaction_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    public function distributionArea(): BelongsTo
    {
        return $this->belongsTo(DistributionArea::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Validate that stock exists at source warehouse before transaction
     * Uses pessimistic locking to prevent race conditions
     */
    public function validateStockAvailability(): void
    {
        // No checks for Adjustments that add stock
        if ($this->type === InventoryTransactionType::Adjustment && $this->quantity > 0) {
            return;
        }

        // Identify source warehouse
        $warehouseId = $this->from_warehouse_id;

        // For distribution/waste/transfer/return, we need source stock
        if (!$warehouseId) {
             if ($this->type === InventoryTransactionType::Adjustment && $this->quantity < 0) {
                  // Negative adjustment might imply reducing from a specific warehouse
                  // If from_warehouse_id is set, check it. If not, maybe it's global? 
                  // Let's enforce from_warehouse_id for negative adjustments in rules.
                  throw ValidationException::withMessages(['from_warehouse_id' => 'Source warehouse required for negative adjustment']);
             }
             return; 
        }

        $query = ProductStock::where('product_id', $this->product_id)
            ->where('warehouse_id', $warehouseId);

        if ($this->batch_id) {
            $query->where('batch_id', $this->batch_id);
        }

        // LOCK THE RECORD
        $stock = $query->lockForUpdate()->first();

        // Check if stock record exists and has enough quantity
        if (!$stock || $stock->quantity < $this->quantity) {
             throw ValidationException::withMessages([
                'quantity' => "Insufficient stock at source warehouse. Available: " . ($stock?->quantity ?? 0),
            ]);
        }
    }

    public function executeTransaction(): void
    {
        // Only allow execution if status is approved (for scheduled) or we are completing it now.
        // The flow is: Approve -> Complete (triggers execution)
        // Or if auto-completion is desired, it happens here.
        
        \DB::transaction(function () {
             $this->validateStockAvailability();

             // 1. Decrement from Source (Transfer, Return, Waste, Distribution, Negative Adjustment)
             if ($this->from_warehouse_id) {
                 $this->decrementStock($this->from_warehouse_id);
             }

             // 2. Increment at Destination (Transfer, Return)
             if ($this->to_warehouse_id && in_array($this->type, [InventoryTransactionType::Transfer, InventoryTransactionType::Return])) {
                 $this->incrementStock($this->to_warehouse_id);
             }
             
             // 3. Handle Distribution Record
             if ($this->type === InventoryTransactionType::Distribution) {
                 $this->createDistributionRecord();
             }

             // 4. Mark Completed if not already
             if ($this->status !== InventoryTransactionStatus::Completed) {
                 $this->update(['status' => InventoryTransactionStatus::Completed]);
             }
        });
    }

    protected function decrementStock($warehouseId)
    {
        $stock = ProductStock::firstOrCreate([
            'product_id' => $this->product_id,
            'warehouse_id' => $warehouseId,
            'batch_id' => $this->batch_id,
        ], ['quantity' => 0]);

        // We already locked in validateStockAvailability if within same transaction? 
        // query->lockForUpdate() in validation locks the row. 
        // Here we read again. To be safe/correct given we just want to update:
        // $stock->decrement... works directly on DB.
        
        $stock->decrement('quantity', $this->quantity);
    }

    protected function incrementStock($warehouseId)
    {
         $stock = ProductStock::firstOrCreate([
            'product_id' => $this->product_id,
            'warehouse_id' => $warehouseId,
            'batch_id' => $this->batch_id,
        ], ['quantity' => 0]);

        $stock->increment('quantity', $this->quantity);
    }
    
    protected function createDistributionRecord()
    {
        // Check if already exists to avoid duplicates if re-run
        if ($this->distributionRecords()->exists()) {
            return;
        }

        $this->distributionRecords()->create([
            'distribution_area_id' => $this->distribution_area_id,
            'product_id' => $this->product_id,
            'batch_id' => $this->batch_id,
            'quantity' => $this->quantity,
            'distributed_at' => now(),
            'notes' => $this->notes,
            // 'beneficiary_count' -> could be added to transaction or derived
        ]);
    }
}
