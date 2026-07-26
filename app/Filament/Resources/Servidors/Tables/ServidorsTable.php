<?php

namespace App\Filament\Resources\Servidors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ServidorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('apellido')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('telefono')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('iglesia.nombre')
                    ->label('Iglesia')
                    ->sortable(),

                IconColumn::make('activo')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since(),


            ])
            ->filters([
                TernaryFilter::make('activo')
                    ->label('Activo'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
