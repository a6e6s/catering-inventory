<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductUnit: string implements HasLabel
{
    case Portion = 'portion';
    case Tray = 'tray';
    case Box = 'box';
    case Package = 'package';
    case MealPack = 'meal_pack';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Portion => __('product.units.portion'),
            self::Tray => __('product.units.tray'),
            self::Box => __('product.units.box'),
            self::Package => __('product.units.package'),
            self::MealPack => __('product.units.meal_pack'),
        };
    }
}
