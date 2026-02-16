<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\Section::make(__('user.sections.user_details'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('user.fields.name')),
                        TextEntry::make('email')
                            ->label(__('user.fields.email'))
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->label(__('user.fields.phone'))
                            ->icon('heroicon-m-phone'),
                        TextEntry::make('role')
                            ->label(__('user.fields.role'))
                            ->badge(),
                        TextEntry::make('warehouse.name')
                            ->label(__('user.fields.warehouse'))
                            ->placeholder('-'),
                        TextEntry::make('email_verified_at')
                            ->label(__('user.fields.email_verified_at'))
                            ->dateTime()
                            ->placeholder('Not Verified')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('created_at')
                            ->label(__('user.fields.created_at'))
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
