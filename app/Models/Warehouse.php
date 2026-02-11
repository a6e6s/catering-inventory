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
            'is_active' => 'boolean',
        ];
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function fromWarehouses(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function toWarehouses(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function distributionRecords(): HasMany
    {
        return $this->hasMany(DistributionRecord::class);
    }
}
