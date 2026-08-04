<?php

namespace App\Filament\Resources\Eventos\Tables;

use App\Enums\EstadoEvento;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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
                    ->color(fn (EstadoEvento $state): string|array|null => $state->getColor())
                    ->icon(fn (EstadoEvento $state): ?string => $state->getIcon()),
                TextColumn::make('estado')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        EstadoEvento::PENDIENTE => 'warning',
                        EstadoEvento::ORGANIZADO => 'success',
                        EstadoEvento::REALIZADO => 'info',
                        EstadoEvento::CANCELADO => 'danger',
                    })
                    ->icon(fn ($state) => $state->getIcon()),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since(),
            ])

            ->filters([
                SelectFilter::make('estado')
                    ->options(EstadoEvento::options()),

                SelectFilter::make('iglesia_id')
                    ->relationship('iglesia', 'nombre'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
