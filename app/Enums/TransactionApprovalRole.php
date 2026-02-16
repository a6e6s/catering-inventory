<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionApprovalRole: string implements HasLabel
{
    case Receiver = 'receiver';
    case WarehouseManager = 'warehouse_manager';
    case ComplianceOfficer = 'compliance_officer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Receiver => __('transaction_approval.roles.receiver'),
            self::WarehouseManager => __('transaction_approval.roles.warehouse_manager'),
            self::ComplianceOfficer => __('transaction_approval.roles.compliance_officer'),
        };
    }
}
