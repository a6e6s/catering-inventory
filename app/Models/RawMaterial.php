<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
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
        'min_stock_level',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'min_stock_level' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredients')
            ->using(ProductIngredient::class)
            ->withPivot(['quantity_required', 'unit'])
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        // This requires aggregation of batches which might be complex in a single query scope
        // For now, we structure it to allow extension
        return $query; 
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    public function getTotalStockAttribute(): float
    {
        return $this->batches()
            ->where('expiry_date', '>', now())
            ->sum('quantity');
    }

    public function getExpiredBatchCountAttribute(): int
    {
        return $this->batches()
            ->where('expiry_date', '<', now())
            ->count();
    }

    public function hasUsage(): bool
    {
        return $this->products()->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (RawMaterial $rawMaterial) {
            if ($rawMaterial->hasUsage()) {
                // Prevent deletion if used in products
                // Localization key will be used here
                throw new \Exception('Cannot delete raw material used in active products.');
            }
        });
    }
}
