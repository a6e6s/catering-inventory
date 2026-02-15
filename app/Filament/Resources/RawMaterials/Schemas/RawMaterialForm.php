<?php

namespace App\Filament\Resources\RawMaterials\Schemas;

use App\Enums\Unit;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RawMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('raw_material.sections.basic_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('raw_material.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('unit')
                            ->label(__('raw_material.fields.unit'))
                            ->options(Unit::class)
                            ->required(),
                        Textarea::make('description')
                            ->label(__('raw_material.fields.description'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make(__('raw_material.sections.inventory_settings'))
                    ->schema([
                        TextInput::make('min_stock_level')
                            ->label(__('raw_material.fields.min_stock_level'))
                            ->helperText(__('raw_material.fields.min_stock_level_helper'))
                            ->numeric()
                            ->default(10)
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label(__('raw_material.fields.is_active'))
                            ->helperText(__('raw_material.fields.is_active_helper'))
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
