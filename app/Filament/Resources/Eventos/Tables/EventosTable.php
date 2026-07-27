<?php

namespace App\Filament\Resources\Eventos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('eventoRecurrente.nombre')
                    ->label('Plantilla')
                    ->placeholder('-'),

                TextColumn::make('fecha')
                    ->date()
                    ->sortable(),

                TextColumn::make('hora_inicio')
                    ->time(),
                TextColumn::make('estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'confirmado' => 'info',
                        'pendiente' => 'warning',
                        'realizado' => 'success',
                        'cancelado' => 'danger',
                    }),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since(),
            ])

            ->filters([

                SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'realizado' => 'Realizado',
                        'cancelado' => 'Cancelado',
                    ]),

                SelectFilter::make('iglesia_id')
                    ->relationship('iglesia', 'nombre'),
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
