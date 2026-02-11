<?php

namespace App\Filament\Resources\TransactionApprovals\Pages;

use App\Filament\Resources\TransactionApprovals\TransactionApprovalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactionApproval extends CreateRecord
{
    protected static string $resource = TransactionApprovalResource::class;
}
