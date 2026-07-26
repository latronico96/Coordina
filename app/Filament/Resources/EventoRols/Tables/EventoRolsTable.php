<?php

namespace App\Filament\Resources\EventoRols\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EventoRolsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('eventoRecurrente.nombre')
                    ->label('Evento')
                    ->searchable(),

                TextColumn::make('rolServicio.nombre')
                    ->label('Rol')
                    ->searchable(),

                TextColumn::make('cantidad')
                    ->sortable(),
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
