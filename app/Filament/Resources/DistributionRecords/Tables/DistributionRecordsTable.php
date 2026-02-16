<?php

namespace App\Filament\Resources\DistributionRecords\Tables;

use App\Models\DistributionRecord;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DistributionRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('distribution_record.fields.id'))
                    ->searchable()
                    ->formatStateUsing(fn ($state) => substr($state, 0, 8).'...')
                    ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),
                TextColumn::make('transaction.id')
                    ->searchable()
                    ->label(__('distribution_record.fields.transaction'))
                    ->formatStateUsing(fn ($state) => substr($state, 0, 8).'...')
                    ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),
                TextColumn::make('distributionArea.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('distribution_record.fields.distribution_area')),
                TextColumn::make('beneficiaries_served')
                    ->numeric()
                    ->sortable()
                    ->label(__('distribution_record.fields.beneficiaries_served')),
                TextColumn::make('status')
                    ->badge(),
                ImageColumn::make('photos')
                    ->label(__('distribution_record.fields.photos'))
                    ->circular()
                    ->stacked()
                    ->limit(3),
                TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('distribution_record.fields.verified_at')),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('inventory_transaction.fields.status')) // Reusing generic status label or creating specific one
                    ->options(\App\Enums\DistributionRecordStatus::class),
                SelectFilter::make('distribution_area_id')
                    ->relationship('distributionArea', 'name')
                    ->label(__('distribution_record.fields.distribution_area')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('verify')
                    ->label(__('distribution_record.actions.verify'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (DistributionRecord $record) => $record->verify(auth()->user()))
                    ->visible(fn (DistributionRecord $record) => auth()->user()->can('verify', $record)),
                Action::make('reject')
                    ->label(__('distribution_record.actions.reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Textarea::make('reason')
                            ->label(__('distribution_record.fields.rejection_reason'))
                            ->required(),
                    ])
                    ->action(fn (DistributionRecord $record, array $data) => $record->reject(auth()->user(), $data['reason']))
                    ->visible(fn (DistributionRecord $record) => auth()->user()->can('reject', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
