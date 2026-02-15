<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum WarehouseType: string implements HasLabel, HasColor, HasIcon
{
    case Main = 'main';
    case Association = 'association';
    case DistributionPoint = 'distribution_point';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Main => __('warehouse.types.main'),
            self::Association => __('warehouse.types.association'),
            self::DistributionPoint => __('warehouse.types.distribution_point'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Main => 'primary',
            self::Association => 'info',
            self::DistributionPoint => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Main => 'heroicon-o-building-storefront',
            self::Association => 'heroicon-o-building-office-2',
            self::DistributionPoint => 'heroicon-o-map-pin',
        };
    }
}
