<?php

namespace App\Filament\Resources\EventoRols\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventoRolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('evento_recurrente_id')
                    ->relationship('eventoRecurrente', 'nombre')
                    ->required(),

                Select::make('rol_servicio_id')
                    ->relationship('rolServicio', 'nombre')
                    ->required(),

                TextInput::make('cantidad')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
            ]);
    }
}
