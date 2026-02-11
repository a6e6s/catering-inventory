<?php

namespace App\Filament\Resources\Batches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('rawMaterial.name')
                    ->label('Raw material'),
                TextEntry::make('warehouse.name')
                    ->label('Warehouse'),
                TextEntry::make('lot_number'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('expiry_date')
                    ->date(),
                TextEntry::make('received_date')
                    ->date(),
                TextEntry::make('status'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
