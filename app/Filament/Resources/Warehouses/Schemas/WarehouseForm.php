<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use App\Enums\WarehouseType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class WarehouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('warehouse.sections.basic_information'))
                    ->description(__('warehouse.sections.basic_information_description'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('warehouse.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('type')
                            ->label(__('warehouse.fields.type'))
                            ->options(WarehouseType::class)
                            ->required()
                            ->default(WarehouseType::Association)
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                // Logic for handling type changes can be added here
                            }),
                        TextInput::make('location')
                            ->label(__('warehouse.fields.location'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make(__('warehouse.sections.operational_settings'))
                    ->description(__('warehouse.sections.operational_settings_description'))
                    ->schema([
                        TextInput::make('capacity')
                            ->label(__('warehouse.fields.capacity'))
                            ->numeric()
                            ->minValue(0)
                            ->placeholder(__('warehouse.fields.capacity_placeholder'))
                            ->default(null)
                            ->helperText(__('warehouse.fields.capacity_helper')),
                        Toggle::make('is_active')
                            ->label(__('warehouse.fields.is_active'))
                            ->default(true)
                            ->helperText(__('warehouse.fields.is_active_helper'))
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->offColor('danger'),
                    ])->columns(2),
            ]);
    }
}
