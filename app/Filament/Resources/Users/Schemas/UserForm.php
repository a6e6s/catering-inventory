<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('user.sections.user_details'))
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
                            ->options(UserRole::class)
                            ->required()
                            ->searchable()
                            ->live(),
                        Select::make('warehouse_id')
                            ->label(__('user.fields.warehouse'))
                            ->relationship('warehouse', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => in_array(
                                $get('role') instanceof UserRole ? $get('role')->value : $get('role'),
                                [UserRole::WarehouseStaff->value, UserRole::Receiver->value]
                            ))
                            ->required(fn (\Filament\Schemas\Components\Utilities\Get $get) => in_array(
                                $get('role') instanceof UserRole ? $get('role')->value : $get('role'),
                                [UserRole::WarehouseStaff->value, UserRole::Receiver->value]
                            )),
                    ])->columns(2),

                Section::make(__('user.sections.security'))
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
