<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InventoryTransactionStatus: string implements HasLabel, HasColor
{
    case Draft = 'draft';
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => __('inventory_transaction.statuses.draft'),
            self::PendingApproval => __('inventory_transaction.statuses.pending_approval'),
            self::Approved => __('inventory_transaction.statuses.approved'),
            self::Rejected => __('inventory_transaction.statuses.rejected'),
            self::Completed => __('inventory_transaction.statuses.completed'),
            self::Cancelled => __('inventory_transaction.statuses.cancelled'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::PendingApproval => 'warning',
            self::Approved => 'info',
            self::Rejected => 'danger',
            self::Completed => 'success',
            self::Cancelled => 'gray',
        };
    }
}
