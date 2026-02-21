<?php

namespace App\Filament\Resources\Batches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('batch.sections.general'))
                    ->schema([
                        Select::make('raw_material_id')
                            ->label(__('batch.fields.raw_material'))
                            ->relationship('rawMaterial', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('warehouse_id')
                            ->label(__('batch.fields.warehouse'))
                            ->relationship('warehouse', 'name', fn ($query) => $query->main())
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('lot_number')
                            ->label(__('batch.fields.lot_number'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('quantity')
                            ->label(__('batch.fields.quantity'))
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])->columns(2),
                Section::make(__('batch.sections.dates'))
                    ->schema([
                        DatePicker::make('received_date')
                            ->label(__('batch.fields.received_date'))
                            ->required()
                            ->maxDate(now())
                            ->default(now()),
                        DatePicker::make('expiry_date')
                            ->label(__('batch.fields.expiry_date'))
                            // ->required()
                            ->afterOrEqual('received_date'),
                        Select::make('status')
                            ->label(__('batch.fields.status'))
                            ->options(\App\Enums\BatchStatus::class)
                            ->required()
                            ->default(\App\Enums\BatchStatus::Active),
                        Textarea::make('notes')
                            ->label(__('batch.fields.notes'))
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
