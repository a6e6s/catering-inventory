<?php

namespace App\Filament\Resources\InventoryTransactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InventoryTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('inventory_transaction.sections.transaction_information'))
                    ->schema([
                        TextEntry::make('transaction_date')
                            ->label(__('inventory_transaction.fields.transaction_date'))
                            ->dateTime(),
                        TextEntry::make('type')
                            ->label(__('inventory_transaction.fields.type'))
                            ->badge(),
                        TextEntry::make('status')
                            ->label(__('inventory_transaction.fields.status'))
                            ->badge(),
                        TextEntry::make('initiatedBy.name')
                            ->label(__('inventory_transaction.fields.initiated_by')),
                    ])->columns(2),

                Section::make(__('inventory_transaction.sections.movement_details'))
                    ->schema([
                        TextEntry::make('fromWarehouse.name')
                            ->label(__('inventory_transaction.fields.from_warehouse'))
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('toWarehouse.name')
                            ->label(__('inventory_transaction.fields.to_warehouse'))
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('distributionArea.name')
                            ->label(__('inventory_transaction.fields.distribution_area'))
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('product.name')
                            ->label(__('inventory_transaction.fields.product')),
                        TextEntry::make('batch.lot_number')
                            ->label(__('inventory_transaction.fields.batch'))
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('quantity')
                            ->label(__('inventory_transaction.fields.quantity'))
                            ->numeric(),
                        TextEntry::make('actual_quantity_received')
                            ->label(__('inventory_transaction.fields.actual_quantity_received'))
                            ->numeric()
                            ->placeholder(__('inventory_transaction.placeholders.na'))
                            ->color(fn ($record) => $record->hasVariance() ? 'warning' : null),
                    ])->columns(2),

                Section::make(__('inventory_transaction.sections.status_and_approval'))
                    ->schema([
                        TextEntry::make('completedBy.name')
                            ->label(__('inventory_transaction.fields.completed_by'))
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('completed_at')
                            ->label(__('inventory_transaction.fields.completed_at'))
                            ->dateTime()
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('rejectedBy.name')
                            ->label(__('inventory_transaction.fields.rejected_by'))
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                        TextEntry::make('rejected_at')
                            ->label(__('inventory_transaction.fields.rejected_at'))
                            ->dateTime()
                            ->placeholder(__('inventory_transaction.placeholders.na')),
                    ])->columns(2)
                    ->collapsible(),

                Section::make(__('inventory_transaction.fields.notes'))
                    ->schema([
                        TextEntry::make('notes')
                            ->label(__('inventory_transaction.fields.notes'))
                            ->markdown(),
                    ])->collapsible(),
            ]);
    }
}
