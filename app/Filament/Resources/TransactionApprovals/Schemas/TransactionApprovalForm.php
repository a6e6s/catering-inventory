<?php

namespace App\Filament\Resources\TransactionApprovals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionApprovalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaction_id')
                    ->relationship('transaction', 'id')
                    ->required(),
                TextInput::make('approver_role')
                    ->required(),
                Select::make('approver_id')
                    ->relationship('approver', 'name')
                    ->required(),
                TextInput::make('step')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Textarea::make('comments')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('approved_at'),
            ]);
    }
}
