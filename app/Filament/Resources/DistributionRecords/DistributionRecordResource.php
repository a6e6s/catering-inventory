<?php

namespace App\Filament\Resources\DistributionRecords;

use App\Filament\Resources\DistributionRecords\Pages\CreateDistributionRecord;
use App\Filament\Resources\DistributionRecords\Pages\EditDistributionRecord;
use App\Filament\Resources\DistributionRecords\Pages\ListDistributionRecords;
use App\Filament\Resources\DistributionRecords\Pages\ViewDistributionRecord;
use App\Filament\Resources\DistributionRecords\Schemas\DistributionRecordForm;
use App\Filament\Resources\DistributionRecords\Schemas\DistributionRecordInfolist;
use App\Filament\Resources\DistributionRecords\Tables\DistributionRecordsTable;
use App\Models\DistributionRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistributionRecordResource extends Resource
{
    protected static ?string $model = DistributionRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.groups.inventory_management');
    }

    public static function getModelLabel(): string
    {
        return __('distribution_record.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('distribution_record.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('distribution_record.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return DistributionRecordForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DistributionRecordInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistributionRecordsTable::configure($table);
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
            'index' => ListDistributionRecords::route('/'),
            'create' => CreateDistributionRecord::route('/create'),
            'view' => ViewDistributionRecord::route('/{record}'),
            'edit' => EditDistributionRecord::route('/{record}/edit'),
        ];
    }
}
