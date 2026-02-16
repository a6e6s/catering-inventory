<?php

namespace App\Filament\Resources\TransactionApprovals;

use App\Filament\Resources\TransactionApprovals\Pages\CreateTransactionApproval;
use App\Filament\Resources\TransactionApprovals\Pages\EditTransactionApproval;
use App\Filament\Resources\TransactionApprovals\Pages\ListTransactionApprovals;
use App\Filament\Resources\TransactionApprovals\Pages\ViewTransactionApproval;
use App\Filament\Resources\TransactionApprovals\Schemas\TransactionApprovalForm;
use App\Filament\Resources\TransactionApprovals\Schemas\TransactionApprovalInfolist;
use App\Filament\Resources\TransactionApprovals\Tables\TransactionApprovalsTable;
use App\Models\TransactionApproval;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TransactionApprovalResource extends Resource
{
    protected static ?string $model = TransactionApproval::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    public static function getModelLabel(): string
    {
        return __('transaction_approval.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('transaction_approval.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('transaction_approval.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return TransactionApprovalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransactionApprovalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionApprovalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactionApprovals::route('/'),
            'create' => CreateTransactionApproval::route('/create'),
            'view' => ViewTransactionApproval::route('/{record}'),
            'edit' => EditTransactionApproval::route('/{record}/edit'),
        ];
    }
}
