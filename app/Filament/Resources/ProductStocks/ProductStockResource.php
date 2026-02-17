<?php

namespace App\Filament\Resources\ProductStocks;

use App\Filament\Resources\ProductStocks\Pages\CreateProductStock;
use App\Filament\Resources\ProductStocks\Pages\EditProductStock;
use App\Filament\Resources\ProductStocks\Pages\ListProductStocks;
use App\Filament\Resources\ProductStocks\Pages\ViewProductStock;
use App\Filament\Resources\ProductStocks\Schemas\ProductStockForm;
use App\Filament\Resources\ProductStocks\Schemas\ProductStockInfolist;
use App\Filament\Resources\ProductStocks\Tables\ProductStocksTable;
use App\Models\ProductStock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductStockResource extends Resource
{
    protected static ?string $model = ProductStock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('product_stock.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('product_stock.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('product_stock.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.groups.stock_control');
    }

    public static function form(Schema $schema): Schema
    {
        return ProductStockForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductStockInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductStocksTable::configure($table);
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
            'index' => ListProductStocks::route('/'),
            'create' => CreateProductStock::route('/create'),
            'view' => ViewProductStock::route('/{record}'),
            'edit' => EditProductStock::route('/{record}/edit'),
        ];
    }
}
