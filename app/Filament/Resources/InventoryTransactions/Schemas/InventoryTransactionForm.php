<?php

namespace App\Filament\Resources\InventoryTransactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InventoryTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->required(),
                Select::make('from_warehouse_id')
                    ->relationship('fromWarehouse', 'name'),
                Select::make('to_warehouse_id')
                    ->relationship('toWarehouse', 'name'),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Select::make('batch_id')
                    ->relationship('batch', 'id'),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                TextInput::make('initiated_by')
                    ->required()
                    ->numeric(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('transaction_date')
                    ->required(),
            ]);
    }
}
