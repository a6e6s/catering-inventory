<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class WarehouseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('warehouse.sections.warehouse_details'))
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('warehouse.fields.name'))
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->size(TextSize::Large),
                        TextEntry::make('location')
                            ->label(__('warehouse.fields.location'))
                            ->icon('heroicon-m-map-pin'),
                        TextEntry::make('type')
                            ->label(__('warehouse.fields.type'))
                            ->badge(),
                        IconEntry::make('is_active')
                            ->label(__('warehouse.fields.is_active'))
                            ->boolean(),
                    ])->columns(2),

                Section::make(__('warehouse.sections.statistics'))
                    ->schema([
                        TextEntry::make('users_count')
                            ->label(__('warehouse.columns.users_count'))
                            ->state(fn ($record) => $record->users()->count()),
                        TextEntry::make('batches_count')
                            ->label(__('warehouse.columns.batches_count'))
                            ->state(fn ($record) => $record->batches()->count()),
                        TextEntry::make('product_stocks_count')
                            ->label(__('warehouse.columns.stock_count'))
                            ->state(fn ($record) => $record->productStocks()->count()),
                    ])->columns(3),

                Section::make('Capacity')
                    ->schema([
                        TextEntry::make('capacity')
                            ->label(__('warehouse.fields.capacity'))
                            ->formatStateUsing(fn ($state) => $state ? number_format($state) : 'Unlimited'),
                        TextEntry::make('capacity_percentage')
                            ->label(__('warehouse.widgets.capacity_utilization'))
                            ->color(fn ($state) => $state > 80 ? 'danger' : ($state > 50 ? 'warning' : 'success'))
                            ->formatStateUsing(fn ($state) => $state.'%'),
                    ])->columns(2),
            ]);
    }
}
