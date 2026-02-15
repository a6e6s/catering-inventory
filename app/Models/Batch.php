<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'raw_material_id',
        'warehouse_id',
        'lot_number',
        'quantity',
        'expiry_date',
        'received_date',
        'status',
        'notes',
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
            'expiry_date' => 'date',
            'received_date' => 'date',
            'status' => \App\Enums\BatchStatus::class,
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Batch $batch) {
            // Auto-create initial inventory transaction
            $batch->inventoryTransactions()->create([
                'type' => \App\Enums\InventoryTransactionType::Received,
                'product_id' => null, // This is raw material batch, not product
                'raw_material_id' => $batch->raw_material_id, // If transaction supports it, or just rely on batch_id
                'from_warehouse_id' => null,
                'to_warehouse_id' => $batch->warehouse_id,
                'quantity' => $batch->quantity,
                'transaction_date' => now(),
                'status' => 'completed', // Assuming transaction status is string or enum
                'notes' => 'Inbound Stock (Initial Batch Creation)',
                // initiated_by should be auth user, but might be null in seeders/tests
                'initiated_by' => auth()->id(),
            ]);
        });
    }

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\BatchStatus::Active);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', \App\Enums\BatchStatus::Expired)
                     ->orWhere(function ($q) {
                         $q->whereNotNull('expiry_date')
                           ->where('expiry_date', '<', now());
                     });
    }

    public function scopeExpiringSoon($query, int $days = 7)
    {
        return $query->whereNotNull('expiry_date')
                     ->where('expiry_date', '>', now())
                     ->where('expiry_date', '<=', now()->addDays($days));
    }

    public function scopeFifo($query)
    {
        // For FIFO, null expiry might mean last? Or just rely on received_date
        return $query->orderBy('received_date', 'asc')
                     ->orderBy('expiry_date', 'asc');
    }

    // Helpers
    public function isExpired(): bool
    {
        if ($this->status === \App\Enums\BatchStatus::Expired) {
            return true;
        }
        
        if ($this->expiry_date === null) {
            return false;
        }

        return $this->expiry_date->isPast();
    }

    public function daysUntilExpiry(): int
    {
        if ($this->expiry_date === null) {
            return PHP_INT_MAX; // Never expires
        }
        
        return (int) now()->diffInDays($this->expiry_date, false);
    }
}
