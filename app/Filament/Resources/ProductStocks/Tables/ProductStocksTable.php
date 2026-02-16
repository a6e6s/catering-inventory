<?php

namespace App\Filament\Resources\ProductStocks\Tables;

use App\Models\ProductStock;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label(__('product_stock.fields.product'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('warehouse.name')
                    ->label(__('product_stock.fields.warehouse'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('batch.lot_number')
                    ->label(__('product_stock.fields.batch'))
                    ->placeholder(__('product_stock.placeholders.na'))
                    ->toggleable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->label(__('product_stock.fields.quantity'))
                    ->sortable()
                    ->color(fn ($record) => $record->quantity <= 10 ? 'danger' : 'success'),
                TextColumn::make('status')
                    ->badge()
                    ->label(__('product_stock.fields.status'))
                    ->color(fn (string $state): string => match ($state) {
                        ProductStock::STATUS_IN_STOCK => 'success',
                        ProductStock::STATUS_LOW_STOCK => 'warning',
                        ProductStock::STATUS_OUT_OF_STOCK => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __('product_stock.status_options.'.$state)),
                TextColumn::make('last_updated')
                    ->dateTime()
                    ->label(__('product_stock.fields.last_updated'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('warehouse')
                    ->label(__('product_stock.fields.warehouse'))
                    ->relationship('warehouse', 'name'),
                Filter::make('low_stock')
                    ->query(fn ($query) => $query->lowStock())
                    ->label(__('product_stock.filters.low_stock')),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk delete allowed
            ]);
    }
}
