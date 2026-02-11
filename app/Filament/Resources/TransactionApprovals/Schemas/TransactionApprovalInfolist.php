<?php

namespace App\Filament\Resources\TransactionApprovals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionApprovalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('transaction.id')
                    ->label('Transaction'),
                TextEntry::make('approver_role'),
                TextEntry::make('approver.name')
                    ->label('Approver'),
                TextEntry::make('step')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('comments')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('approved_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
