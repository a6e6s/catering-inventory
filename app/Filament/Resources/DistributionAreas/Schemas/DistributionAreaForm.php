<?php

namespace App\Filament\Resources\DistributionAreas\Schemas;

use App\Models\DistributionArea;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DistributionAreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('distribution_area.sections.basic_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('distribution_area.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        TextInput::make('slug')
                            ->label(__('distribution_area.fields.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('location')
                            ->label(__('distribution_area.fields.location'))
                            ->required()
                            ->rows(2)
                            ->columnSpanFull()
                            ->helperText(__('distribution_area.fields.location_helper')),
                        Select::make('warehouse_id')
                            ->label(__('distribution_area.fields.warehouse'))
                            ->relationship('warehouses', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText(__('distribution_area.fields.warehouse_helper')),
                    ])->columns(2),

                Section::make(__('distribution_area.sections.contact_and_capacity'))
                    ->schema([
                        TextInput::make('contact_person')
                            ->label(__('distribution_area.fields.contact_person'))
                            ->maxLength(255),
                        TextInput::make('contact_phone')
                            ->label(__('distribution_area.fields.contact_phone'))
                            ->tel()
                            ->helperText(__('distribution_area.fields.contact_phone_helper')),
                        TextInput::make('capacity')
                            ->label(__('distribution_area.fields.capacity'))
                            ->numeric()
                            ->default(200)
                            ->minValue(10)
                            ->helperText(__('distribution_area.fields.capacity_helper')),
                        Select::make('distribution_frequency')
                            ->label(__('distribution_area.fields.distribution_frequency'))
                            // Note: FREQUENCIES keys should be localized in model or here. 
                            // Using model keys map to localized string is better.
                            ->options(collect(DistributionArea::FREQUENCIES)->mapWithKeys(fn($v, $k) => [$k => __('distribution_area.enums.'.$k)]))
                            ->default('weekly')
                            ->required(),
                    ])->columns(2),

                Section::make(__('distribution_area.sections.operational_settings'))
                    ->schema([
                        Toggle::make('requires_photo_verification')
                            ->label(__('distribution_area.fields.requires_photo_verification'))
                            ->default(true)
                            ->helperText(__('distribution_area.fields.requires_photo_verification_helper')),
                        Toggle::make('is_active')
                            ->label(__('distribution_area.fields.is_active'))
                            ->default(true)
                            ->helperText(__('distribution_area.fields.is_active_helper')),
                        Textarea::make('notes')
                            ->label(__('distribution_area.fields.notes'))
                            ->maxLength(1000)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText(__('distribution_area.fields.notes_helper')),
                    ]),
            ]);
    }
}
