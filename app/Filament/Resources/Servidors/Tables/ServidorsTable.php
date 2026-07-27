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
            ->modifyQueryUsing(
                fn ($query) => $query->with(['rolesServicio', 'iglesia'])
            )
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->formatStateUsing(
                        fn ($state, $record) => "{$record->nombre} {$record->apellido}"
                    )
                    ->searchable(['nombre', 'apellido'])
                    ->sortable(),

                TextColumn::make('telefono')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('rolesServicio.nombre')
                    ->label('Roles')
                    ->state(
                        fn ($record) => $record->rolesServicio
                            ->pluck('nombre')
                            ->implode(', ')
                    ),

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
