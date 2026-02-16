<?php

namespace App\Filament\Resources\DistributionRecords\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DistributionRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('distribution_record.sections.distribution_details'))
                    ->schema([
                        Select::make('transaction_id')
                            ->relationship('transaction', 'id')
                            ->required()
                            ->disabled() // Link is immutable
                            ->label(__('distribution_record.fields.transaction_id'))
                            ->columnSpan(1),
                        Select::make('distribution_area_id')
                            ->relationship('distributionArea', 'name')
                            ->required()
                            ->label(__('distribution_record.fields.distribution_area'))
                            ->columnSpan(1),
                        TextInput::make('beneficiaries_served')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label(__('distribution_record.fields.beneficiaries_served'))
                            ->helperText(__('distribution_record.fields.beneficiaries_helper'))
                            ->columnSpan(1),
                        Select::make('status')
                            ->options(\App\Enums\DistributionRecordStatus::class)
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->label(__('inventory_transaction.fields.status'))
                            ->columnSpan(1),
                    ])->columns(2),

                Section::make(__('distribution_record.sections.evidence'))
                    ->schema([
                        FileUpload::make('photos')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('distribution-photos')
                            ->imageEditor()
                            ->columnSpanFull()
                            ->label(__('distribution_record.fields.photos')),
                        RichEditor::make('notes')
                            ->label(__('distribution_record.fields.notes'))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('distribution_record.sections.verification'))
                    ->schema([
                        TextInput::make('verified_by')
                            ->formatStateUsing(fn ($state) => \App\Models\User::find($state)?->name)
                            ->disabled()
                            ->label(__('distribution_record.fields.verified_by')),
                        DateTimePicker::make('verified_at')
                            ->disabled()
                            ->label(__('distribution_record.fields.verified_at')),
                        Textarea::make('rejection_reason')
                            ->visible(fn ($record) => $record?->status === \App\Enums\DistributionRecordStatus::Rejected)
                            ->disabled()
                            ->columnSpanFull()
                            ->label(__('distribution_record.fields.rejection_reason')),
                    ])->columns(2)
                    ->visible(fn ($record) => $record && $record->status !== \App\Enums\DistributionRecordStatus::Pending),
            ]);
    }
}
