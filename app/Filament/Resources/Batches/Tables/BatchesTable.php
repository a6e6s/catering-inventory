<?php

namespace App\Filament\Resources\Batches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lot_number')
                    ->label(__('batch.fields.lot_number'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('rawMaterial.name')
                    ->label(__('batch.fields.raw_material'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('warehouse.name')
                    ->label(__('batch.fields.warehouse'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label(__('batch.fields.quantity'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('received_date')
                    ->label(__('batch.fields.received_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('expiry_date')
                    ->label(__('batch.fields.expiry_date'))
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->expiry_date->isPast() ? 'danger' : ($record->expiry_date->diffInDays(now()) < 7 ? 'warning' : 'success')),
                TextColumn::make('status')
                    ->label(__('batch.fields.status'))
                    ->badge(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label(__('batch.fields.status'))
                    ->options(\App\Enums\BatchStatus::class),
                \Filament\Tables\Filters\Filter::make('expiring_soon')
                    ->label(__('batch.messages.near_expiry', ['days' => 7]))
                    ->query(fn ($query) => $query->expiringSoon(7))
                    ->toggle(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
