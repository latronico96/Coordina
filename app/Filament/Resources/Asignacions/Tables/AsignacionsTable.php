<?php

namespace App\Filament\Resources\Asignacions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AsignacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('evento.nombre')
                    ->label('Evento')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('evento.fecha')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),

                TextColumn::make('eventoRol.rolServicio.nombre')
                    ->label('Rol')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('servidor.nombre')
                    ->label('Servidor')
                    ->formatStateUsing(
                        fn ($state, $record) =>
                        $record->servidor->nombre . ' ' .
                        $record->servidor->apellido
                    )
                    ->searchable(),

                TextColumn::make('estado')
                    ->badge()
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'confirmado',
                        'danger' => 'rechazado',
                    ]),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
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
