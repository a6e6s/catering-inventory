<?php

namespace App\Filament\Resources\InventoryTransactions\Tables;

use App\Enums\InventoryTransactionStatus;
use App\Enums\InventoryTransactionType;
use App\Models\InventoryTransaction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
                TextColumn::make('actual_quantity_received')
                    ->label(__('inventory_transaction.fields.actual_quantity_received'))
                    ->numeric()
                    ->sortable()
                    ->placeholder(__('inventory_transaction.placeholders.na'))
                    ->color(fn (InventoryTransaction $record) => $record->hasVariance() ? 'warning' : null),
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
                Filter::make('requiring_my_approval')
                    ->label(__('inventory_transaction.filters.requiring_my_approval'))
                    ->query(fn (Builder $query) => $query
                        ->where('status', InventoryTransactionStatus::PendingApproval)
                        ->where('initiated_by', '!=', auth()->id())
                    )
                    ->toggle(),
                Filter::make('has_variance')
                    ->label(__('inventory_transaction.filters.has_variance'))
                    ->query(fn (Builder $query) => $query->withVariance())
                    ->toggle(),
                Filter::make('this_week')
                    ->label(__('inventory_transaction.filters.this_week'))
                    ->query(fn (Builder $query) => $query->where('transaction_date', '>=', now()->startOfWeek()))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->hidden(fn (InventoryTransaction $record) => $record->status !== InventoryTransactionStatus::Draft),

                // Submit for Approval
                Action::make('submit')
                    ->label(__('inventory_transaction.actions.submit'))
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->status === InventoryTransactionStatus::Draft)
                    ->action(fn (InventoryTransaction $record) => $record->update(['status' => InventoryTransactionStatus::PendingApproval])),

                // Approve with optional actual quantity
                Action::make('approve')
                    ->label(__('inventory_transaction.actions.approve'))
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->canBeApprovedBy(auth()->user()))
                    ->form([
                        TextInput::make('actual_quantity')
                            ->label(__('inventory_transaction.fields.actual_quantity_received'))
                            ->numeric()
                            ->minValue(0.01)
                            ->helperText(__('inventory_transaction.messages.actual_qty_help')),
                        Textarea::make('comments')
                            ->label(__('inventory_transaction.fields.comments'))
                            ->rows(2),
                    ])
                    ->action(function (InventoryTransaction $record, array $data) {
                        $record->update(['status' => InventoryTransactionStatus::Approved]);

                        // Create approval record
                        $record->transactionApprovals()
                            ->where('status', \App\Enums\TransactionApprovalStatus::Pending)
                            ->first()
                            ?->update([
                                'user_id' => auth()->id(),
                                'status' => \App\Enums\TransactionApprovalStatus::Approved,
                                'comments' => $data['comments'] ?? null,
                            ]);

                        // Store actual quantity if provided
                        if (! empty($data['actual_quantity'])) {
                            $record->update(['actual_quantity_received' => $data['actual_quantity']]);
                        }
                    }),

                // Reject with mandatory reason
                Action::make('reject')
                    ->label(__('inventory_transaction.actions.reject'))
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->canBeApprovedBy(auth()->user()))
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label(__('inventory_transaction.fields.rejection_reason'))
                            ->required()
                            ->rows(3),
                    ])
                    ->action(fn (InventoryTransaction $record, array $data) => $record->reject($data['rejection_reason'])),

                // Complete (Execute stock movement)
                Action::make('complete')
                    ->label(__('inventory_transaction.actions.complete'))
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn (InventoryTransaction $record) => $record->status === InventoryTransactionStatus::Approved)
                    ->action(function (InventoryTransaction $record) {
                        $actualQty = $record->actual_quantity_received
                            ? (float) $record->actual_quantity_received
                            : null;
                        $record->executeStockAdjustment($actualQty);
                    }),
            ])
            ->defaultSort('transaction_date', 'desc');
    }
}
