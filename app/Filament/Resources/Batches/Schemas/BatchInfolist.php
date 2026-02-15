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
                \Filament\Schemas\Components\Section::make(__('batch.sections.general'))
                    ->schema([
                        TextEntry::make('rawMaterial.name')
                            ->label(__('batch.fields.raw_material')),
                        TextEntry::make('warehouse.name')
                            ->label(__('batch.fields.warehouse')),
                        TextEntry::make('lot_number')
                            ->label(__('batch.fields.lot_number'))
                            ->copyable(),
                        TextEntry::make('quantity')
                            ->label(__('batch.fields.quantity'))
                            ->numeric(),
                    ])->columns(2),
                \Filament\Schemas\Components\Section::make(__('batch.sections.dates'))
                    ->schema([
                        TextEntry::make('received_date')
                            ->label(__('batch.fields.received_date'))
                            ->date(),
                        TextEntry::make('expiry_date')
                            ->label(__('batch.fields.expiry_date'))
                            ->date()
                            ->color(fn ($record) => $record->expiry_date->isPast() ? 'danger' : 'success'),
                        TextEntry::make('status')
                            ->label(__('batch.fields.status'))
                            ->badge(),
                        TextEntry::make('notes')
                            ->label(__('batch.fields.notes'))
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ])->columns(2),
            ]);
    }
}
