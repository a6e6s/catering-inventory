<?php

namespace App\Filament\Resources\TransactionApprovals\Tables;

use App\Models\TransactionApproval;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionApprovalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction.id')
                    ->label(__('transaction_approval.fields.transaction'))
                    ->formatStateUsing(fn ($state) => substr($state, 0, 8).'...')
                    ->fontFamily(\Filament\Support\Enums\FontFamily::Mono)
                    ->searchable(),
                TextColumn::make('step')
                    ->label(__('transaction_approval.fields.step'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approver_role')
                    ->label(__('transaction_approval.fields.approver_role'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('approver.name')
                    ->label(__('transaction_approval.fields.approver_id'))
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('transaction_approval.fields.status'))
                    ->badge(),
                TextColumn::make('approved_at')
                    ->label(__('transaction_approval.fields.approved_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label(__('transaction_approval.fields.status'))
                    ->options(\App\Enums\TransactionApprovalStatus::class),
                \Filament\Tables\Filters\SelectFilter::make('approver_role')
                    ->label(__('transaction_approval.fields.approver_role'))
                    ->options(\App\Enums\TransactionApprovalRole::class),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('approve')
                    ->label(__('transaction_approval.actions.approve'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (TransactionApproval $record) => $record->approve(auth()->user()))
                    ->visible(fn (TransactionApproval $record) => auth()->user()->can('approve', $record)),
                Action::make('reject')
                    ->label(__('transaction_approval.actions.reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('comments')
                            ->label(__('transaction_approval.fields.comments'))
                            ->required(),
                    ])
                    ->action(fn (TransactionApproval $record, array $data) => $record->reject(auth()->user(), $data['comments']))
                    ->visible(fn (TransactionApproval $record) => auth()->user()->can('reject', $record)),
            ])
            ->bulkActions([
                // Bulk actions usually invalid for approvals as they need context
            ]);
    }
}
