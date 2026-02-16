<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('user.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('user.fields.email'))
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable(),
                TextColumn::make('role')
                    ->label(__('user.fields.role'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('warehouse.name')
                    ->label(__('user.fields.warehouse'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('user.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('role')
                    ->label(__('user.fields.role'))
                    ->options(\App\Enums\UserRole::class),
                \Filament\Tables\Filters\SelectFilter::make('warehouse_id')
                    ->label(__('user.fields.warehouse'))
                    ->relationship('warehouse', 'name'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
