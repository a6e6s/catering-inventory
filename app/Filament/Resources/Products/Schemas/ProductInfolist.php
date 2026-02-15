<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('product.sections.general'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('product.fields.name')),
                        TextEntry::make('unit')
                            ->label(__('product.fields.unit'))
                            ->badge(),
                        TextEntry::make('description')
                            ->label(__('product.fields.description'))
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make(__('product.sections.settings'))
                    ->schema([
                        TextEntry::make('preparation_time')
                            ->label(__('product.fields.preparation_time')),
                        IconEntry::make('is_active')
                            ->label(__('product.fields.is_active'))
                            ->boolean(),
                    ])->columns(2),
            ]);
    }
}
