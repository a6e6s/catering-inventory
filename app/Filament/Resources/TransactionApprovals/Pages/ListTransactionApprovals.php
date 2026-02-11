<?php

namespace App\Filament\Resources\TransactionApprovals\Pages;

use App\Filament\Resources\TransactionApprovals\TransactionApprovalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransactionApprovals extends ListRecords
{
    protected static string $resource = TransactionApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
