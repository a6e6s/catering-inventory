<?php

namespace App\Filament\Resources\InventoryTransactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InventoryTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('type'),
                TextEntry::make('fromWarehouse.name')
                    ->label('From warehouse')
                    ->placeholder('-'),
                TextEntry::make('toWarehouse.name')
                    ->label('To warehouse')
                    ->placeholder('-'),
                TextEntry::make('product.name')
                    ->label('Product'),
                TextEntry::make('batch.id')
                    ->label('Batch')
                    ->placeholder('-'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('initiated_by')
                    ->numeric(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('transaction_date')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
