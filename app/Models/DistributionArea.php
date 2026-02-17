<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class DistributionArea extends Model
{
    use HasFactory, HasUuids;

    public const FREQUENCIES = [
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'biweekly' => 'Bi-weekly',
        'monthly' => 'Monthly',
        'on_demand' => 'On Demand',
    ];

    protected $fillable = [
        'name',
        'slug',
        'location',
        'contact_person',
        'contact_phone',
        'capacity',
        'distribution_frequency',
        'notes',
        'photo_thumbnail',
        'requires_photo_verification',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'requires_photo_verification' => 'boolean',
            'capacity' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (DistributionArea $area) {
            if (empty($area->slug)) {
                $area->slug = Str::slug($area->name);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'distribution_area_warehouses')
            ->withTimestamps();
    }

    public function distributionRecords(): HasMany
    {
        return $this->hasMany(DistributionRecord::class)->latest();
    }

    public function latestDistribution(): HasOne
    {
        return $this->hasOne(DistributionRecord::class)->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByWarehouse(Builder $query, string $warehouseId): Builder
    {
        return $query->whereHas('warehouses', function ($q) use ($warehouseId) {
            $q->where('warehouses.id', $warehouseId);
        });
    }

    public function scopeHighDemand(Builder $query): Builder
    {
        // Placeholder logic: Areas with high capacity (e.g. > 300) are considered high potential demand
        // Real implementation would join distribution records and calc utilization
        return $query->where('capacity', '>', 300); 
    }

    public function scopeLowDemand(Builder $query): Builder
    {
        return $query->where('capacity', '<', 100);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Methods
    |--------------------------------------------------------------------------
    */

    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->location, // Can append city/zip if added later
        );
    }

    protected function contactInfo(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->contact_person} | {$this->contact_phone}",
        );
    }

    public function getCapacityUtilization(): int
    {
        // Calculate based on latest distribution or 0
        $latest = $this->latestDistribution;
        if (! $latest || $this->capacity === 0) {
            return 0;
        }
        
        // Assuming distribution record has 'quantity' or similar. 
        // Note: DistributionRecord model check needed to confirm field name.
        // For now preventing division by zero error.
        return 0; 
    }
}
