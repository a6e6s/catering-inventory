<?php

namespace App\Filament\Resources\TransactionApprovals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionApprovalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make(__('transaction_approval.sections.approval_details'))
                    ->schema([
                        Select::make('transaction_id')
                            ->relationship('transaction', 'id')
                            ->required()
                            ->disabled()
                            ->label(__('transaction_approval.fields.transaction_id')),
                        Select::make('approver_role')
                            ->options(\App\Enums\TransactionApprovalRole::class)
                            ->required()
                            ->disabled()
                            ->label(__('transaction_approval.fields.approver_role')),
                        Select::make('approver_id')
                            ->relationship('approver', 'name')
                            ->required()
                            ->disabled()
                            ->label(__('transaction_approval.fields.approver_id')),
                        TextInput::make('step')
                            ->required()
                            ->numeric()
                            ->disabled()
                            ->label(__('transaction_approval.fields.step')),
                        Select::make('status')
                            ->options(\App\Enums\TransactionApprovalStatus::class)
                            ->required()
                            ->disabled()
                            ->label(__('transaction_approval.fields.status')),
                        DateTimePicker::make('approved_at')
                            ->disabled()
                            ->label(__('transaction_approval.fields.approved_at')),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make(__('transaction_approval.sections.comments'))
                    ->schema([
                        Textarea::make('comments')
                            ->label(__('transaction_approval.fields.comments'))
                            ->placeholder(__('transaction_approval.placeholders.comments'))
                            ->rows(3)
                            ->columnSpanFull()
                            ->disabled(fn ($record) => $record && $record->status !== \App\Enums\TransactionApprovalStatus::Pending),
                    ]),
            ]);
    }
}
