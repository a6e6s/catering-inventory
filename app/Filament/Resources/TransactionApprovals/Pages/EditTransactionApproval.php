<?php

namespace App\Filament\Resources\TransactionApprovals\Pages;

use App\Filament\Resources\TransactionApprovals\TransactionApprovalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransactionApproval extends EditRecord
{
    protected static string $resource = TransactionApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
