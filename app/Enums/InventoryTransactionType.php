<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InventoryTransactionType: string implements HasLabel
{
    case Received = 'received';
    case Dispatched = 'dispatched';
    case Adjustment = 'adjustment';
    case Used = 'used';
    case Returned = 'returned';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Received => 'Received',
            self::Dispatched => 'Dispatched',
            self::Adjustment => 'Adjustment',
            self::Used => 'Used',
            self::Returned => 'Returned',
        };
    }
}
