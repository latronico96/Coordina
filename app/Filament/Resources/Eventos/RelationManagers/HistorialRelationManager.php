<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HistorialRelationManager extends RelationManager
{
    protected static string $relationship = 'historial';

    protected static ?string $title = 'Historial';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->sinceTooltip()
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->placeholder('Sistema'),

                TextColumn::make('accion')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => str($state)
                        ->replace('_', ' ')
                        ->title()),
                TextColumn::make('descripcion')
                    ->wrap()
                    ->searchable(),
            ])
            ->recordActions([])
            ->headerActions([]);
    }
}
