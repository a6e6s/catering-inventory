<?php

namespace App\Filament\Resources\TransactionApprovals\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionApprovalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('transaction_approval.sections.approval_details'))
                    ->schema([
                        TextEntry::make('transaction.id')
                            ->label(__('transaction_approval.fields.transaction_id'))
                            ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),
                        TextEntry::make('approver_role')
                            ->badge()
                            ->label(__('transaction_approval.fields.approver_role')),
                        TextEntry::make('approver.name')
                            ->label(__('transaction_approval.fields.approver_id')),
                        TextEntry::make('step')
                            ->numeric()
                            ->label(__('transaction_approval.fields.step')),
                        TextEntry::make('status')
                            ->badge()
                            ->label(__('transaction_approval.fields.status')),
                        TextEntry::make('approved_at')
                            ->dateTime()
                            ->placeholder('-')
                            ->label(__('transaction_approval.fields.approved_at')),
                    ])->columns(2),

                Section::make(__('transaction_approval.sections.comments'))
                    ->schema([
                        TextEntry::make('comments')
                            ->label(__('transaction_approval.fields.comments'))
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
