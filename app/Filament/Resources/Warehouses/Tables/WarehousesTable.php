<?php

namespace App\Filament\Resources\Warehouses\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class WarehousesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Columns start here
                TextColumn::make('name')
                    ->label(__('warehouse.fields.name'))
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('warehouse.fields.type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('location')
                    ->label(__('warehouse.fields.location'))
                    ->searchable(),
                TextColumn::make('capacity')
                    ->label(__('warehouse.fields.capacity'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('warehouse.fields.is_active'))
                    ->boolean(),
                TextColumn::make('users_count')
                    ->label(__('warehouse.columns.users_count'))
                    ->counts('users'),
                TextColumn::make('batches_count')
                    ->label(__('warehouse.columns.batches_count'))
                    ->counts('batches'),
                TextColumn::make('product_stocks_count')
                    ->label(__('warehouse.columns.stock_count'))
                    ->counts('productStocks'),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('type')
                    ->label(__('warehouse.filters.type'))
                    ->options(\App\Enums\WarehouseType::class),
                TernaryFilter::make('is_active')
                    ->label(__('warehouse.filters.is_active')),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('toggle_active')
                        ->label(__('warehouse.actions.toggle_active'))
                        ->icon('heroicon-o-arrow-path')
                        ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['is_active' => ! $record->is_active])))
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
