<?php

namespace App\Filament\Resources\Eventos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('iglesia_id')
                    ->label('Iglesia')
                    ->relationship('iglesia', 'nombre')
                    ->required(),

                Select::make('evento_recurrente_id')
                    ->label('Plantilla')
                    ->relationship('eventoRecurrente', 'nombre')
                    ->searchable()
                    ->preload()
                    ->placeholder('Sin plantilla'),

                TextInput::make('nombre')
                    ->required(),

                DatePicker::make('fecha')
                    ->required(),

                TimePicker::make('hora_inicio')
                    ->required(),

                Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'realizado' => 'Realizado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default('pendiente')
                    ->required(),
            ]);
    }
}
