<?php

namespace App\Filament\Resources\RawMaterials;

use App\Filament\Resources\RawMaterials\Pages\CreateRawMaterial;
use App\Filament\Resources\RawMaterials\Pages\EditRawMaterial;
use App\Filament\Resources\RawMaterials\Pages\ListRawMaterials;
use App\Filament\Resources\RawMaterials\Pages\ViewRawMaterial;
use App\Filament\Resources\RawMaterials\Schemas\RawMaterialForm;
use App\Filament\Resources\RawMaterials\Schemas\RawMaterialInfolist;
use App\Filament\Resources\RawMaterials\Tables\RawMaterialsTable;
use App\Models\RawMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RawMaterialResource extends Resource
{
    protected static ?string $model = RawMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('raw_material.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('raw_material.plural_model_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.groups.master_data');
    }

    public static function getNavigationLabel(): string
    {
        return __('raw_material.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return RawMaterialForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RawMaterialInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RawMaterialsTable::configure($table);
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
            'index' => ListRawMaterials::route('/'),
            'create' => CreateRawMaterial::route('/create'),
            'view' => ViewRawMaterial::route('/{record}'),
            'edit' => EditRawMaterial::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
