<?php

namespace App\Filament\Resources\Eventos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('iglesia.nombre')
                    ->label('Iglesia'),

                TextEntry::make('eventoRecurrente.nombre')
                    ->label('Plantilla')
                    ->placeholder('-'),

                TextEntry::make('nombre'),

                TextEntry::make('fecha')
                    ->date(),

                TextEntry::make('hora_inicio')
                    ->time(),

                TextEntry::make('estado'),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
