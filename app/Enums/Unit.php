<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Unit: string implements HasLabel
{
    case Kg = 'kg';
    case Gram = 'g';
    case Liter = 'l';
    case Milliliter = 'ml';
    case Piece = 'pcs';
    case Box = 'box';
    case Bag = 'bag';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Kg => 'Kilogram (kg)',
            self::Gram => 'Gram (g)',
            self::Liter => 'Liter (l)',
            self::Milliliter => 'Milliliter (ml)',
            self::Piece => 'Piece (pcs)',
            self::Box => 'Box',
            self::Bag => 'Bag',
        };
    }
}
