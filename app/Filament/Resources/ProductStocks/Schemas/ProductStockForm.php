<?php

namespace App\Filament\Resources\ProductStocks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
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
                                    ->disabled()
                                    ->required(),
                                Select::make('warehouse_id')
                                    ->relationship('warehouse', 'name')
                                    ->label(__('product_stock.fields.warehouse'))
                                    ->disabled()
                                    ->required(),
                                Select::make('batch_id')
                                    ->relationship('batch', 'lot_number')
                                    ->label(__('product_stock.fields.batch'))
                                    ->disabled()
                                    ->placeholder(__('product_stock.placeholders.no_specific_batch')),
                            ])->columns(2),

                        Section::make(__('product_stock.sections.quantity_and_status'))
                            ->schema([
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->label(__('product_stock.fields.quantity'))
                                    ->disabled()
                                    ->suffix(fn ($record) => $record?->product?->unit->name ?? __('product_stock.units_suffix')),

                                DateTimePicker::make('last_updated')
                                    ->label(__('product_stock.fields.last_updated'))
                                    ->disabled(),

                                Placeholder::make('status')
                                    ->label(__('product_stock.fields.status'))
                                    ->content(fn ($record) => $record?->status),
                            ])->columns(2),
                    ]),
            ]);
    }
}
