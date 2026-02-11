<?php

namespace App\Filament\Resources\DistributionAreas;

use App\Filament\Resources\DistributionAreas\Pages\CreateDistributionArea;
use App\Filament\Resources\DistributionAreas\Pages\EditDistributionArea;
use App\Filament\Resources\DistributionAreas\Pages\ListDistributionAreas;
use App\Filament\Resources\DistributionAreas\Pages\ViewDistributionArea;
use App\Filament\Resources\DistributionAreas\Schemas\DistributionAreaForm;
use App\Filament\Resources\DistributionAreas\Schemas\DistributionAreaInfolist;
use App\Filament\Resources\DistributionAreas\Tables\DistributionAreasTable;
use App\Models\DistributionArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistributionAreaResource extends Resource
{
    protected static ?string $model = DistributionArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DistributionAreaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DistributionAreaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistributionAreasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDistributionAreas::route('/'),
            'create' => CreateDistributionArea::route('/create'),
            'view' => ViewDistributionArea::route('/{record}'),
            'edit' => EditDistributionArea::route('/{record}/edit'),
        ];
    }
}
