<?php

namespace App\Filament\Resources\DistributionRecords\Pages;

use App\Filament\Resources\DistributionRecords\DistributionRecordResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDistributionRecord extends ViewRecord
{
    protected static string $resource = DistributionRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
