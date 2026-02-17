<?php

namespace App\Filament\Resources\DistributionAreas\Tables;

use App\Models\DistributionArea;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DistributionAreasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_thumbnail')
                    ->label(__('distribution_area.fields.photo_thumbnail')),
                TextColumn::make('name')
                    ->label(__('distribution_area.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('location')
                    ->label(__('distribution_area.fields.location'))
                    ->limit(40)
                    ->tooltip(fn (DistributionArea $record) => $record->location),
                TextColumn::make('contact_person')
                    ->label(__('distribution_area.fields.contact_person'))
                    ->searchable(),
                TextColumn::make('capacity')
                    ->label(__('distribution_area.fields.capacity'))
                    ->sortable()
                    ->badge(),
                // Color logic moved to view/closure if needed complexity increases
                TextColumn::make('distributionRecords_count')
                    ->label(__('distribution_area.fields.distributions_count'))
                    ->counts('distributionRecords'),
                IconColumn::make('requires_photo_verification')
                    ->label(__('distribution_area.fields.requires_photo_verification'))
                    ->boolean()
                    ->trueIcon('heroicon-o-camera')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),
                IconColumn::make('is_active')
                    ->label(__('distribution_area.fields.is_active'))
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->label(__('distribution_area.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('warehouse')
                    ->label(__('distribution_area.filters.warehouse'))
                    ->relationship('warehouses', 'name')
                    ->multiple(),
                TernaryFilter::make('is_active')
                    ->label(__('distribution_area.filters.is_active'))
                    ->trueLabel(__('distribution_area.filters.active'))
                    ->falseLabel(__('distribution_area.filters.inactive')),
                TernaryFilter::make('requires_photo_verification')
                    ->label(__('distribution_area.filters.photo_required')),
                Filter::make('high_utilization')
                    ->query(fn (Builder $query) => $query->highDemand())
                    ->label(__('distribution_area.filters.high_utilization')),
                Filter::make('low_utilization')
                    ->query(fn (Builder $query) => $query->lowDemand())
                    ->label(__('distribution_area.filters.low_utilization')),
            ])
            ->actions([
                ViewAction::make()
                    ->slideOver(),
                EditAction::make(),
                ActionGroup::make([
                    // Custom actions will be added here
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
