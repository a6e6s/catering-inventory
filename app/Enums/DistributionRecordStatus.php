<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DistributionRecordStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => __('distribution_record.status.pending'),
            self::Verified => __('distribution_record.status.verified'),
            self::Rejected => __('distribution_record.status.rejected'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Verified => 'success',
            self::Rejected => 'danger',
        };
    }
}
