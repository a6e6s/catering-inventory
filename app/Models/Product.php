<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'unit',
        'description',
        'preparation_time',
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
            'is_active' => 'boolean',
            'preparation_time' => 'integer',
            'unit' => \App\Enums\ProductUnit::class,
        ];
    }

    public function rawMaterials(): BelongsToMany
    {
        return $this->belongsToMany(RawMaterial::class, 'product_ingredients')
            ->using(ProductIngredient::class)
            ->withPivot('quantity_required', 'unit')
            ->withTimestamps();
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function distributionRecords(): HasMany
    {
        return $this->hasMany(DistributionRecord::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate maximum quantity that can be produced based on available raw materials
     */
    public function calculateMaxProducibleQuantity(?string $warehouseId = null, float $requestedQuantity = 0): int
    {
        $ingredients = $this->ingredients;
        
        if ($ingredients->isEmpty()) {
            return 0;
        }

        $maxQuantities = [];

        foreach ($ingredients as $ingredient) {
            $availableStock = \App\Models\Batch::where('raw_material_id', $ingredient->raw_material_id)
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('expiry_date')
                          ->orWhere('expiry_date', '>', now());
                })
                ->when($warehouseId, fn($q) => $q->where('warehouse_id', $warehouseId))
                ->sum('quantity');

            if ($ingredient->quantity_required <= 0) {
                continue;
            }

            // Calculate remaining stock after consuming for requested quantity
            $remainingStock = $availableStock - ($ingredient->quantity_required * $requestedQuantity);
            
            // Calculate how many more units can be produced with remaining stock
            $maxQuantities[] = floor($remainingStock / $ingredient->quantity_required);
        }

        return empty($maxQuantities) ? 0 : max(0, (int) min($maxQuantities));
    }
}
