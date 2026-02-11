<?php

namespace App\Filament\Resources\DistributionRecords\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DistributionRecordInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('transaction.id')
                    ->label('Transaction'),
                TextEntry::make('distributionArea.name')
                    ->label('Distribution area'),
                TextEntry::make('beneficiaries_served')
                    ->numeric(),
                TextEntry::make('photos')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('verified_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('verified_at')
                    ->dateTime()
                    ->placeholder('-'),
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
