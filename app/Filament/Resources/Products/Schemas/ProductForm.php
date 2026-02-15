<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('product.sections.general'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('product.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('unit')
                            ->label(__('product.fields.unit'))
                            ->options(\App\Enums\ProductUnit::class)
                            ->required(),
                        Textarea::make('description')
                            ->label(__('product.fields.description'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make(__('product.sections.settings'))
                    ->schema([
                        TextInput::make('preparation_time')
                            ->label(__('product.fields.preparation_time'))
                            ->numeric()
                            ->minValue(1)
                            ->step(1),
                        Toggle::make('is_active')
                            ->label(__('product.fields.is_active'))
                            ->required()
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
