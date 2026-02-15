<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'location',
        'capacity',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => \App\Enums\WarehouseType::class,
            'is_active' => 'boolean',
            'capacity' => 'integer',
        ];
    }

    // Relationships

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function fromTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'from_warehouse_id');
    }

    public function toTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'to_warehouse_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function distributionRecords(): HasMany
    {
        return $this->hasMany(DistributionRecord::class)->through('toTransactions');
    }

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, \App\Enums\WarehouseType $type)
    {
        return $query->where('type', $type);
    }

    public function scopeMain($query)
    {
        return $query->where('type', \App\Enums\WarehouseType::Main);
    }

    // Accessors & Mutators

    public function getCapacityPercentageAttribute(): float
    {
        if (!$this->capacity || $this->capacity <= 0) {
            return 0;
        }

        $currentStock = $this->currentStock();

        return round(($currentStock / $this->capacity) * 100, 2);
    }

    public function getIsMainAttribute(): bool
    {
        return $this->type === \App\Enums\WarehouseType::Main;
    }

    // Business Logic Methods

    public function currentStock(): float
    {
        // Calculate total stock from ProductStock model
        return (float) $this->productStocks()->sum('quantity');

        // Alternatively, could sum batches if that's the source of truth
        // return (float) $this->batches()->sum('quantity');
    }

    public function hasCapacityFor(float $incomingQuantity): bool
    {
        if (is_null($this->capacity)) {
            return true; // Unlimited capacity
        }

        return ($this->currentStock() + $incomingQuantity) <= $this->capacity;
    }

    public function isNearCapacity(): bool
    {
        return $this->capacity_percentage >= 80;
    }

    public function canReceiveFrom(Warehouse $source): bool
    {
        // 1. Inactive cannot receive
        if (!$this->is_active) {
            return false;
        }

        // 2. Type Restrictions
        // Main can send to ANY
        if ($source->type === \App\Enums\WarehouseType::Main) {
            return true;
        }

        // Association can ONLY receive from Main (already covered above)
        if ($this->type === \App\Enums\WarehouseType::Association) {
            // Since we are here, source is NOT Main (checked above).
            // So Association cannot receive from non-Main.
            return false;
        }

        // Distribution points can ONLY receive from Association
        if ($this->type === \App\Enums\WarehouseType::DistributionPoint) {
            return $source->type === \App\Enums\WarehouseType::Association;
        }

        return false;
    }

    public static function mainWarehouse(): ?self
    {
        return self::main()->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Warehouse $warehouse) {
            if ($warehouse->type === \App\Enums\WarehouseType::Main) {
                // Prevent deletion of Main Warehouse
                throw new \Exception(__('warehouse.messages.main_warehouse_delete_error'));
            }
        });

        static::saved(function (Warehouse $warehouse) {
            // Check if capacity is > 80% and trigger notification
            // To prevent spamming, we check if it WAS below 80% before this save
            if ($warehouse->isNearCapacity() && $warehouse->wasChanged('capacity')) {
                // Send to all admins
                $admins = \App\Models\User::where('role', 'admin')->get();
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\CapacityWarningNotification($warehouse));
            }
        });
    }
}
