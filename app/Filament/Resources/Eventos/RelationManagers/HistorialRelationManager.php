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
            ->columns([

                TextColumn::make('created_at')
                    ->dateTime(),

                TextColumn::make('user.name')
                    ->label('Usuario'),

                TextColumn::make('accion'),

                TextColumn::make('descripcion'),

            ]);
    }
}
