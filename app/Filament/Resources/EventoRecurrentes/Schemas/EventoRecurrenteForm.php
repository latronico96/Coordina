<?php

namespace App\Filament\Resources\EventoRecurrentes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventoRecurrenteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),

                Select::make('dia_semana')
                    ->options([
                        1 => 'Lunes',
                        2 => 'Martes',
                        3 => 'Miércoles',
                        4 => 'Jueves',
                        5 => 'Viernes',
                        6 => 'Sábado',
                        7 => 'Domingo',
                    ])
                    ->required(),

                TimePicker::make('hora_inicio')
                    ->seconds(false)
                    ->required(),

                Toggle::make('activo')
                    ->default(true),

            ]);
    }
}
