<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum BatchStatus: string implements HasLabel, HasColor
{
    case Active = 'active';
    case Expired = 'expired';
    case Quarantined = 'quarantined';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => __('batch.status.active'),
            self::Expired => __('batch.status.expired'),
            self::Quarantined => __('batch.status.quarantined'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Expired => 'danger',
            self::Quarantined => 'warning',
        };
    }
}
