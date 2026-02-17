<?php

namespace App\Filament\Resources\InventoryTransactions;

use App\Filament\Resources\InventoryTransactions\Pages\CreateInventoryTransaction;
use App\Filament\Resources\InventoryTransactions\Pages\EditInventoryTransaction;
use App\Filament\Resources\InventoryTransactions\Pages\ListInventoryTransactions;
use App\Filament\Resources\InventoryTransactions\Pages\ViewInventoryTransaction;
use App\Filament\Resources\InventoryTransactions\Schemas\InventoryTransactionForm;
use App\Filament\Resources\InventoryTransactions\Schemas\InventoryTransactionInfolist;
use App\Filament\Resources\InventoryTransactions\Tables\InventoryTransactionsTable;
use App\Models\InventoryTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InventoryTransactionResource extends Resource
{
    protected static ?string $model = InventoryTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('inventory_transaction.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('inventory_transaction.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('inventory_transaction.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.groups.inventory_management');
    }

    public static function form(Schema $schema): Schema
    {
        return InventoryTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InventoryTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApprovalsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventoryTransactions::route('/'),
            'create' => CreateInventoryTransaction::route('/create'),
            'view' => ViewInventoryTransaction::route('/{record}'),
            'edit' => EditInventoryTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if (! $user) {
            return $query;
        }

        if ($user->hasRole('admin')) {
            return $query;
        }

        if ($user->hasRole('warehouse_staff') && $user->warehouse_id) {
            return $query->where(function ($q) use ($user) {
                $q->where('from_warehouse_id', $user->warehouse_id)
                    ->orWhere('to_warehouse_id', $user->warehouse_id);
            });
        }

        if ($user->hasRole('receiver') && $user->warehouse_id) {
            return $query->where('to_warehouse_id', $user->warehouse_id);
        }

        if ($user->hasRole('compliance_officer')) {
            return $query->whereIn('type', [
                \App\Enums\InventoryTransactionType::Waste,
                \App\Enums\InventoryTransactionType::Distribution,
            ]);
        }

        return $query;
    }
}
