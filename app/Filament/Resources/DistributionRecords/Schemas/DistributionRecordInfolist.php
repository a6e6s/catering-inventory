<?php

namespace App\Filament\Resources\DistributionRecords\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DistributionRecordInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('distribution_record.sections.record_information'))
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->label(__('inventory_transaction.fields.status')),
                        TextEntry::make('transaction.id')
                            ->label(__('distribution_record.fields.transaction_id'))
                            ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),
                        TextEntry::make('distributionArea.name')
                            ->label(__('distribution_record.fields.distribution_area')),
                        TextEntry::make('beneficiaries_served')
                            ->numeric()
                            ->label(__('distribution_record.fields.beneficiaries_served')),
                    ])->columns(2),

                Section::make(__('distribution_record.sections.evidence'))
                    ->schema([
                        ImageEntry::make('photos')
                            ->label(__('distribution_record.fields.photo_gallery'))
                            ->placeholder(__('distribution_record.placeholders.no_photos'))
                            ->columnSpanFull()
                            ->height(200),
                        TextEntry::make('notes')
                            ->html()
                            ->label(__('distribution_record.fields.notes'))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('distribution_record.sections.verification_details'))
                    ->schema([
                        TextEntry::make('verifiedBy.name')
                            ->label(__('distribution_record.fields.verified_by'))
                            ->placeholder('-'),
                        TextEntry::make('verified_at')
                            ->dateTime()
                            ->label(__('distribution_record.fields.verified_at'))
                            ->placeholder('-'),
                        TextEntry::make('rejection_reason')
                            ->label(__('distribution_record.fields.rejection_reason'))
                            ->color('danger')
                            ->visible(fn ($record) => $record->rejection_reason)
                            ->columnSpanFull(),
                    ])->columns(2)
                    ->visible(fn ($record) => $record->verified_at),
            ]);
    }
}
