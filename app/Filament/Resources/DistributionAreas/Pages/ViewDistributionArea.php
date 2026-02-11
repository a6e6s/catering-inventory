<?php

namespace App\Filament\Resources\DistributionAreas\Pages;

use App\Filament\Resources\DistributionAreas\DistributionAreaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDistributionArea extends ViewRecord
{
    protected static string $resource = DistributionAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
