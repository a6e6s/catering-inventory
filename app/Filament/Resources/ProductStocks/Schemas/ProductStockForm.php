<?php

namespace App\Filament\Resources\ProductStocks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductStockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make(__('product_stock.sections.stock_information'))
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->label(__('product_stock.fields.product'))
                                    ->live()
                                    ->required(),
                                Select::make('warehouse_id')
                                    ->relationship('warehouse', 'name')
                                    ->label(__('product_stock.fields.warehouse'))
                                    ->live()
                                    ->required(),
                            ])->columns(2),

                        Section::make(__('product_stock.sections.quantity_and_status'))
                            ->schema([
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->label(__('product_stock.fields.quantity'))
                                    ->required()
                                    ->minValue(1)
                                    ->live(onBlur: true)
                                    ->helperText(function ($get) {
                                        $productId = $get('product_id');
                                        $warehouseId = $get('warehouse_id');
                                        $quantity = $get('quantity') ?: 0;
                                        
                                        if (!$productId || !$warehouseId) {
                                            return null;
                                        }
                                        
                                        $product = \App\Models\Product::find($productId);
                                        if (!$product) {
                                            return null;
                                        }
                                        
                                        $maxQty = $product->calculateMaxProducibleQuantity($warehouseId, $quantity);
                                        
                                        return __('product_stock.validation.max_available', ['max' => $maxQty]);
                                    })
                                    ->suffix(fn ($record) => $record?->product?->unit?->name ?? __('product_stock.units_suffix')),

                                DateTimePicker::make('last_updated')
                                    ->label(__('product_stock.fields.last_updated')),
                            ])->columns(2),
                    ]),
            ]);
    }
}
