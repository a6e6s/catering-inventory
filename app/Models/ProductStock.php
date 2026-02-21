<?php

namespace App\Models;

use App\Observers\ProductStockObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ProductStockObserver::class)]
class ProductStock extends Model
{
    use HasFactory, HasUuids;

    public const STATUS_IN_STOCK = 'in_stock';

    public const STATUS_LOW_STOCK = 'low_stock';

    public const STATUS_OUT_OF_STOCK = 'out_of_stock';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'batch_id',
        'quantity',
        'last_updated',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'last_updated' => 'timestamp',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->last_updated = now();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeByWarehouse(Builder $query, string $warehouseId): Builder
    {
        return $query->where('warehouse_id', $warehouseId);
    }

    public function scopeByProduct(Builder $query, string $productId): Builder
    {
        return $query->where('product_id', $productId);
    }

    public function scopeLowStock(Builder $query, float $threshold = 10): Builder
    {
        return $query->where('quantity', '<=', $threshold)->where('quantity', '>', 0);
    }

    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('quantity', '<=', 0);
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereHas('batch', function ($q) {
            $q->where('expiry_date', '<', now());
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getStatusAttribute(): string
    {
        if ($this->quantity <= 0) {
            return self::STATUS_OUT_OF_STOCK;
        }

        // Default threshold, logically should be configurable per product
        $threshold = 10;

        if ($this->quantity <= $threshold) {
            return self::STATUS_LOW_STOCK;
        }

        return self::STATUS_IN_STOCK;
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Check if stock is sufficient for request
     */
    public function hasSufficientStock(float $requestedQuantity): bool
    {
        return $this->quantity >= $requestedQuantity;
    }

    /**
     * Get validation rules
     */
    public static function rules(mixed $id = null): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'batch_id' => ['nullable', 'exists:batches,id'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'last_updated' => ['nullable', 'date'],
        ];
    }
}
