<?php

namespace App\Filament\Resources\DistributionAreas\Pages;

use App\Filament\Resources\DistributionAreas\DistributionAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDistributionAreas extends ListRecords
{
    protected static string $resource = DistributionAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
