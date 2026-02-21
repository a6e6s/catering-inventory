<?php

namespace App\Filament\Resources\RawMaterials\Tables;

use App\Models\RawMaterial;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RawMaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('raw_material.fields.name'))
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit')
                    ->label(__('raw_material.fields.unit'))
                    ->badge(),
                TextColumn::make('total_stock')
                    ->label(__('raw_material.columns.total_stock'))
                    ->getStateUsing(fn (RawMaterial $record) => 
                        $record->batches()
                            ->where('status', 'active')
                            ->where(function($query) {
                                $query->whereNull('expiry_date')
                                      ->orWhere('expiry_date', '>', now());
                            })
                            ->sum('quantity')
                    )
                    ->numeric(2)
                    ->suffix(fn (RawMaterial $record) => ' ' . $record->unit),
                TextColumn::make('min_stock_level')
                    ->label(__('raw_material.fields.min_stock_level'))
                    ->numeric()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label(__('raw_material.fields.is_active'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('updated_at')) // Assuming generic key or file
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('raw_material.filters.is_active')),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
