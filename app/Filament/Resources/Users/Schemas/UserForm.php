<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make(__('user.sections.user_details'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('user.fields.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('user.fields.email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('phone')
                            ->label(__('user.fields.phone'))
                            ->tel()
                            ->maxLength(255)
                            ->default(null),
                        Select::make('role')
                            ->label(__('user.fields.role'))
                            ->options(\App\Enums\UserRole::class)
                            ->required()
                            ->searchable(),
                        Select::make('warehouse_id')
                            ->label(__('user.fields.warehouse'))
                            ->relationship('warehouse', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (\Filament\Schemas\Components\Component $component) => true), // Logic to show/hide based on role if needed
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make(__('user.sections.security'))
                    ->schema([
                        TextInput::make('password')
                            ->label(__('user.fields.password'))
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => \Illuminate\Support\Facades\Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->confirmed(),
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }
}
