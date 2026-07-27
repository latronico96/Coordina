<?php

namespace App\Filament\Resources\EventoRecurrentes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventoRecurrenteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextEntry::make('iglesia.nombre')
                    ->label('Iglesia'),

                TextEntry::make('nombre'),

                TextEntry::make('dia_semana')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        1 => 'Lunes',
                        2 => 'Martes',
                        3 => 'Miércoles',
                        4 => 'Jueves',
                        5 => 'Viernes',
                        6 => 'Sábado',
                        7 => 'Domingo',
                    }),

                TextEntry::make('hora_inicio'),

                IconEntry::make('activo')
                    ->boolean(),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),

            ]);
    }
}
