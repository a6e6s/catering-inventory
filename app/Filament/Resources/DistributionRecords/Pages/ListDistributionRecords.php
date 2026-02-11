<?php

namespace App\Filament\Resources\DistributionRecords\Pages;

use App\Filament\Resources\DistributionRecords\DistributionRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDistributionRecords extends ListRecords
{
    protected static string $resource = DistributionRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
