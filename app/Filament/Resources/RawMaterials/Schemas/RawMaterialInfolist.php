<?php

namespace App\Filament\Resources\RawMaterials\Schemas;

use App\Models\RawMaterial;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RawMaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('raw_material.sections.basic_information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('raw_material.fields.name'))
                            ->weight('bold'),
                        TextEntry::make('unit')
                            ->label(__('raw_material.fields.unit'))
                            ->badge(),
                        TextEntry::make('description')
                            ->label(__('raw_material.fields.description'))
                            ->placeholder('-')
                            ->columnSpanFull(),
                        IconEntry::make('is_active')
                            ->label(__('raw_material.fields.is_active'))
                            ->boolean(),
                    ])->columns(2),

                Section::make(__('raw_material.sections.statistics'))
                    ->schema([
                        TextEntry::make('total_stock')
                            ->label(__('raw_material.columns.total_stock'))
                            ->state(fn (RawMaterial $record) => number_format($record->total_stock, 2) . ' ' . $record->unit),
                        TextEntry::make('created_at')
                            ->label(__('raw_material.fields.created_at')) // Assuming generic or file
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
