<?php

namespace App\Filament\Resources\InventoryTransactions\Schemas;

use App\Enums\InventoryTransactionStatus;
use App\Models\ProductStock;
use App\Enums\InventoryTransactionType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class InventoryTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make(__('inventory_transaction.sections.transaction_details'))
                            ->schema([
                                Select::make('type')
                                    ->label(__('inventory_transaction.fields.type'))
                                    ->options(InventoryTransactionType::class)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('to_warehouse_id', null))
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),

                                Select::make('status')
                                    ->label(__('inventory_transaction.fields.status'))
                                    ->options(InventoryTransactionStatus::class)
                                    ->required()
                                    ->default(InventoryTransactionStatus::Draft)
                                    ->disabled()
                                    ->dehydrated(),

                                DateTimePicker::make('transaction_date')
                                    ->label(__('inventory_transaction.fields.transaction_date'))
                                    ->default(now())
                                    ->required()
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),
                            ])->columnSpan(1),

                        Section::make(__('inventory_transaction.sections.warehouse_information'))
                            ->schema([
                                Select::make('from_warehouse_id')
                                    ->label(__('inventory_transaction.fields.from_warehouse'))
                                    ->relationship('fromWarehouse', 'name', fn (Builder $query, Get $get) => $query->when($get('to_warehouse_id'), fn ($q, $id) => $q->where('id', '!=', $id))
                                    )
                                    ->required(fn ($get) => in_array($get('type') instanceof InventoryTransactionType ? $get('type')->value : $get('type'), [
                                        InventoryTransactionType::Transfer->value,
                                        InventoryTransactionType::Return->value,
                                        InventoryTransactionType::Waste->value,
                                        InventoryTransactionType::Distribution->value,
                                    ]))
                                    ->live() // To filter batches or valid products later if needed
                                    ->different('to_warehouse_id')
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),

                                Select::make('to_warehouse_id')
                                    ->label(__('inventory_transaction.fields.to_warehouse'))
                                    ->relationship('toWarehouse', 'name', fn (Builder $query, Get $get) => $query->when($get('from_warehouse_id'), fn ($q, $id) => $q->where('id', '!=', $id))
                                    )
                                    ->required(fn ($get) => in_array($get('type') instanceof InventoryTransactionType ? $get('type')->value : $get('type'), [
                                        InventoryTransactionType::Transfer->value,
                                        InventoryTransactionType::Return->value,
                                    ]))
                                    ->visible(fn ($get) => in_array($get('type') instanceof InventoryTransactionType ? $get('type')->value : $get('type'), [
                                        InventoryTransactionType::Transfer->value,
                                        InventoryTransactionType::Return->value,
                                    ]))
                                    ->different('from_warehouse_id')
                                    ->live()
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),

                                Select::make('distribution_area_id')
                                    ->label('Distribution Area') // Localize later: __('inventory_transaction.fields.distribution_area')
                                    ->relationship('distributionArea', 'name')
                                    ->required(fn ($get) => ($get('type') instanceof InventoryTransactionType ? $get('type')->value : $get('type')) === InventoryTransactionType::Distribution->value)
                                    ->visible(fn ($get) => ($get('type') instanceof InventoryTransactionType ? $get('type')->value : $get('type')) === InventoryTransactionType::Distribution->value)
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),
                            ])->columnSpan(1),
                    ]),

                Section::make(__('inventory_transaction.sections.item_details'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->label(__('inventory_transaction.fields.product'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('batch_id', null))
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),

                                Select::make('batch_id')
                                    ->relationship('batch', 'lot_number', fn ($query, $get) => $query->where('product_id', $get('product_id'))
                                        ->when($get('from_warehouse_id'), fn ($q, $wId) => $q->where('warehouse_id', $wId))
                                    )
                                    ->label(__('inventory_transaction.fields.batch'))
                                    ->searchable()
                                    ->preload()
                                    ->disabled(fn ($get) => ! $get('product_id') || ($get('record') && $get('record')->status !== InventoryTransactionStatus::Draft))
                                    ->placeholder(fn ($get) => $get('product_id') ? __('inventory_transaction.placeholders.select_batch') : __('inventory_transaction.placeholders.select_product_first')),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->label(__('inventory_transaction.fields.quantity'))
                                    ->required()
                                    ->minValue(0.01)
                                    ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft)
                                    ->maxValue(function ($get) {
                                        $type = $get('type');
                                        $typeVal = $type instanceof InventoryTransactionType ? $type->value : $type;

                                        $warehouseId = $get('from_warehouse_id');
                                        $productId = $get('product_id');
                                        $batchId = $get('batch_id');

                                        if (! $warehouseId || ! $productId) {
                                            return null;
                                        }

                                        // Check if type requires stock validation
                                        if (! in_array($typeVal, [
                                            InventoryTransactionType::Transfer->value,
                                            InventoryTransactionType::Return->value,
                                            InventoryTransactionType::Waste->value,
                                            InventoryTransactionType::Distribution->value,
                                        ])) {
                                            return null;
                                        }

                                        $query = ProductStock::where('product_id', $productId)
                                            ->where('warehouse_id', $warehouseId);

                                        if ($batchId) {
                                            $query->where('batch_id', $batchId);
                                        }

                                        return $query->sum('quantity');
                                    })
                                    ->helperText(function ($get) {
                                        $type = $get('type');
                                        $typeVal = $type instanceof InventoryTransactionType ? $type->value : $type;

                                        $warehouseId = $get('from_warehouse_id');
                                        $productId = $get('product_id');
                                        $batchId = $get('batch_id');

                                        if (! $warehouseId || ! $productId) {
                                            return null;
                                        }

                                        if (! in_array($typeVal, [
                                            InventoryTransactionType::Transfer->value,
                                            InventoryTransactionType::Return->value,
                                            InventoryTransactionType::Waste->value,
                                            InventoryTransactionType::Distribution->value,
                                        ])) {
                                            return null;
                                        }

                                        $query = ProductStock::where('product_id', $productId)
                                            ->where('warehouse_id', $warehouseId);

                                        if ($batchId) {
                                            $query->where('batch_id', $batchId);
                                        }

                                        $qty = $query->sum('quantity');

                                        return __('Available: ').$qty;
                                    }),
                            ]),

                        RichEditor::make('notes')
                            ->label(__('inventory_transaction.fields.notes'))
                            ->columnSpanFull()
                            ->disabled(fn ($record) => $record && $record->status !== InventoryTransactionStatus::Draft),

                        Hidden::make('initiated_by')
                            ->default(fn () => auth()->id()),
                    ]),
            ]);
    }
}
