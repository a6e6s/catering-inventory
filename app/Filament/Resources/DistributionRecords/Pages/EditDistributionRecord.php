<?php

namespace App\Filament\Resources\DistributionRecords\Pages;

use App\Filament\Resources\DistributionRecords\DistributionRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDistributionRecord extends EditRecord
{
    protected static string $resource = DistributionRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
