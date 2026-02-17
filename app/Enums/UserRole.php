<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case Admin = 'admin';
    case WarehouseStaff = 'warehouse_staff';
    case Receiver = 'receiver';
    case ComplianceOfficer = 'compliance_officer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => __('user.roles.admin'),
            self::WarehouseStaff => __('user.roles.warehouse_staff'),
            self::Receiver => __('user.roles.receiver'),
            self::ComplianceOfficer => __('user.roles.compliance_officer'),
        };
    }
}
