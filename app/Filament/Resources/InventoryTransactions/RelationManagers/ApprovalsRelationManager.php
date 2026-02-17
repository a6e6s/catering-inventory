<?php

namespace App\Filament\Resources\InventoryTransactions\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApprovalsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactionApprovals';

    protected static ?string $title = null;

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('inventory_transaction.sections.approval_history');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('step')
                    ->label(__('inventory_transaction.fields.approval_step'))
                    ->sortable(),
                TextColumn::make('role')
                    ->label(__('inventory_transaction.fields.approval_role'))
                    ->badge(),
                TextColumn::make('user.name')
                    ->label(__('inventory_transaction.fields.approved_by'))
                    ->placeholder('-'),
                TextColumn::make('status')
                    ->label(__('inventory_transaction.fields.status'))
                    ->badge(),
                TextColumn::make('comments')
                    ->label(__('inventory_transaction.fields.comments'))
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->comments),
                TextColumn::make('created_at')
                    ->label(__('inventory_transaction.fields.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('step', 'asc');
    }
}
