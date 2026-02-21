<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InventoryTransactionType: string implements HasLabel, HasColor
{
    case Transfer = 'transfer';
    case Return = 'return';
    case Waste = 'waste';
    case Distribution = 'distribution';
    case Adjustment = 'adjustment';
    case Production = 'production';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Transfer => __('inventory_transaction.types.transfer'),
            self::Return => __('inventory_transaction.types.return'),
            self::Waste => __('inventory_transaction.types.waste'),
            self::Distribution => __('inventory_transaction.types.distribution'),
            self::Adjustment => __('inventory_transaction.types.adjustment'),
            self::Production => __('inventory_transaction.types.production'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Transfer => 'info',
            self::Return => 'warning',
            self::Waste => 'danger',
            self::Distribution => 'success',
            self::Adjustment => 'gray',
            self::Production => 'primary',
        };
    }
}
