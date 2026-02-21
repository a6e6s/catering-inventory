<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\RawMaterial;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RawMaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'rawMaterials';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('raw_material.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pivot.quantity_required')
                    ->label(__('product.fields.quantity_required'))
                    ->numeric(2)
                    ->sortable(),
                TextColumn::make('pivot.unit')
                    ->label(__('product.fields.unit'))
                    ->searchable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name'])
                    ->schema([
                        Select::make('recordId')
                            ->label(__('raw_material.single'))
                            ->options(fn () => RawMaterial::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $rawMaterial = RawMaterial::find($state);
                                    if ($rawMaterial) {
                                        $set('unit', $rawMaterial->unit);
                                    }
                                }
                            }),
                        TextInput::make('quantity_required')
                            ->label(__('product.fields.quantity_required'))
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->step(0.01)
                            ->default(1),
                        TextInput::make('unit')
                            ->label(__('product.fields.unit'))
                            ->required()
                            ->maxLength(50)
                            ->readOnly(),
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
