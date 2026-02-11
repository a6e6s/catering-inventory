<?php

namespace App\Filament\Resources\DistributionAreas\Pages;

use App\Filament\Resources\DistributionAreas\DistributionAreaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDistributionArea extends EditRecord
{
    protected static string $resource = DistributionAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
