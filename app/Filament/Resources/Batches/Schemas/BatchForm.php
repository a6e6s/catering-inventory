<?php

namespace App\Filament\Resources\Batches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('raw_material_id')
                    ->relationship('rawMaterial', 'name')
                    ->required(),
                Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required(),
                TextInput::make('lot_number')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                DatePicker::make('expiry_date')
                    ->required(),
                DatePicker::make('received_date')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
