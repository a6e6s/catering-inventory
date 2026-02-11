<?php

namespace App\Filament\Resources\DistributionAreas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DistributionAreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location')
                    ->required(),
                TextInput::make('contact_person')
                    ->default(null),
                TextInput::make('contact_phone')
                    ->tel()
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
