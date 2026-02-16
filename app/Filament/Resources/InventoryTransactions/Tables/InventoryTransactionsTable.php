<?php

namespace App\Filament\Resources\InventoryTransactions\Tables;

use App\Enums\InventoryTransactionStatus;
use App\Enums\InventoryTransactionType;
use App\Models\InventoryTransaction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InventoryTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_date')
                    ->label(__('inventory_transaction.fields.transaction_date'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('inventory_transaction.fields.type'))
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fromWarehouse.name')
                    ->label(__('inventory_transaction.fields.from_warehouse'))
                    ->sortable()
                    ->searchable()
                    ->placeholder(__('inventory_transaction.placeholders.na')),
                TextColumn::make('toWarehouse.name')
                    ->label(__('inventory_transaction.fields.to_warehouse'))
                    ->sortable()
                    ->searchable()
                    ->placeholder(__('inventory_transaction.placeholders.na')),
                TextColumn::make('product.name')
                    ->label(__('inventory_transaction.fields.product'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label(__('inventory_transaction.fields.quantity'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('inventory_transaction.fields.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('initiatedBy.name')
                    ->label(__('inventory_transaction.fields.initiated_by'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('inventory_transaction.fields.type'))
                    ->options(InventoryTransactionType::class),
                SelectFilter::make('status')
                    ->label(__('inventory_transaction.fields.status'))
                    ->options(InventoryTransactionStatus::class),
                SelectFilter::make('warehouse')
                    ->relationship('fromWarehouse', 'name')
                    ->label(__('inventory_transaction.fields.from_warehouse')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->hidden(fn (InventoryTransaction $record) => $record->status !== InventoryTransactionStatus::Draft),
                
                // Submit for Approval
                Action::make('submit')
                    ->label('Submit') // Localize: __('inventory_transaction.actions.submit')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->status === InventoryTransactionStatus::Draft)
                    ->action(fn (InventoryTransaction $record) => $record->update(['status' => InventoryTransactionStatus::PendingApproval])),

                // Approve
                Action::make('approve')
                    ->label(__('inventory_transaction.actions.approve'))
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->status === InventoryTransactionStatus::PendingApproval)
                    ->action(function (InventoryTransaction $record) {
                        $record->update(['status' => InventoryTransactionStatus::Approved]);
                        // If auto-execute is desired for some types, do it here. 
                        // But requirement says "Approved but not yet executed".
                    }),

                // Reject
                Action::make('reject')
                    ->label(__('inventory_transaction.actions.reject'))
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->form([
                        TextInput::make('rejection_reason')
                            ->label('Reason')
                            ->required()
                    ])
                    ->visible(fn (InventoryTransaction $record) => $record->status === InventoryTransactionStatus::PendingApproval)
                    ->action(function (InventoryTransaction $record, array $data) {
                        $record->update([
                            'status' => InventoryTransactionStatus::Rejected,
                            'notes' => $record->notes . "\nRejection Reason: " . $data['rejection_reason']
                        ]);
                    }),

                // Complete (Execute)
                Action::make('complete')
                    ->label('Complete') // Localize: __('inventory_transaction.actions.complete')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->status === InventoryTransactionStatus::Approved)
                    ->action(function (InventoryTransaction $record) {
                        $record->executeTransaction(); // This sets status to Completed and moves stock
                    }),
            ])
            ->defaultSort('transaction_date', 'desc');
    }
}
