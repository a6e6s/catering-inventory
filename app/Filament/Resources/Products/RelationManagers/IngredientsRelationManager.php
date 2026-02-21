<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\RawMaterial;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IngredientsRelationManager extends RelationManager
{
    protected static string $relationship = 'ingredients';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('raw_material_id')
                    ->label(__('raw_material.single'))
                    ->options(RawMaterial::pluck('name', 'id'))
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rawMaterial.name')
                    ->label(__('raw_material.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity_required')
                    ->label(__('product.fields.quantity_required'))
                    ->numeric(2)
                    ->sortable(),
                TextColumn::make('unit')
                    ->label(__('product.fields.unit')),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
