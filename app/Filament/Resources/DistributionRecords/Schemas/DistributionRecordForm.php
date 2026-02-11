<?php

namespace App\Filament\Resources\DistributionRecords\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DistributionRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaction_id')
                    ->relationship('transaction', 'id')
                    ->required(),
                Select::make('distribution_area_id')
                    ->relationship('distributionArea', 'name')
                    ->required(),
                TextInput::make('beneficiaries_served')
                    ->required()
                    ->numeric(),
                Textarea::make('photos')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('verified_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('verified_at'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
