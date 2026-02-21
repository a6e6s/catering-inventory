<?php

namespace App\Filament\Resources\ProductStocks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductStockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('product_stock.sections.stock_information'))
                    ->schema([
                        TextEntry::make('product.name')
                            ->label(__('product_stock.fields.product')),
                        TextEntry::make('warehouse.name')
                            ->label(__('product_stock.fields.warehouse')),
                        TextEntry::make('batch.lot_number')
                            ->label(__('product_stock.fields.batch'))
                            ->placeholder(__('product_stock.placeholders.na')),
                    ])->columns(3),

                Section::make(__('product_stock.sections.quantity_and_status'))
                    ->schema([
                        TextEntry::make('quantity')
                            ->label(__('product_stock.fields.quantity'))
                            ->numeric()
                            ->suffix(fn ($record) => ' ' . ($record->product?->unit?->name ?? ''))
                            ->color(fn ($record) => $record->quantity <= 10 ? 'danger' : 'success'),
                        TextEntry::make('status')
                            ->label(__('product_stock.fields.status'))
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => __('product_stock.status_options.'.$state))
                            ->color(fn (string $state): string => match ($state) {
                                'in_stock' => 'success',
                                'low_stock' => 'warning',
                                'out_of_stock' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('last_updated')
                            ->label(__('product_stock.fields.last_updated'))
                            ->dateTime(),
                    ])->columns(3),
            ]);
    }
}
