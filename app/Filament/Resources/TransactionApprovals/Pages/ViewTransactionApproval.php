<?php

namespace App\Filament\Resources\TransactionApprovals\Pages;

use App\Filament\Resources\TransactionApprovals\TransactionApprovalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTransactionApproval extends ViewRecord
{
    protected static string $resource = TransactionApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
