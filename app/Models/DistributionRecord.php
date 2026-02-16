<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionRecord extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'distribution_area_id',
        'beneficiaries_served',
        'photos',
        'verified_by',
        'verified_at',
        'notes',
        'status',
        'rejection_reason',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'verified_at' => 'timestamp',
            'status' => \App\Enums\DistributionRecordStatus::class,
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->status)) {
                $model->status = \App\Enums\DistributionRecordStatus::Pending;
            }
        });
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

    public function distributionArea(): BelongsTo
    {
        return $this->belongsTo(DistributionArea::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', \App\Enums\DistributionRecordStatus::Pending);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', \App\Enums\DistributionRecordStatus::Verified);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', \App\Enums\DistributionRecordStatus::Rejected);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    public function verify(User $user)
    {
        $this->update([
            'status' => \App\Enums\DistributionRecordStatus::Verified,
            'verified_by' => $user->id,
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);
    }

    public function reject(User $user, string $reason)
    {
        $this->update([
            'status' => \App\Enums\DistributionRecordStatus::Rejected,
            'verified_by' => $user->id,
            'verified_at' => now(),
            'rejection_reason' => $reason,
        ]);
    }
}
