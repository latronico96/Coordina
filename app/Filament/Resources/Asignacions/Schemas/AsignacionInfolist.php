<?php

namespace App\Filament\Resources\Asignacions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AsignacionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('evento_id')
                    ->numeric(),
                TextEntry::make('evento_rol_id')
                    ->numeric(),
                TextEntry::make('servidor_id')
                    ->numeric(),
                TextEntry::make('estado'),
                TextEntry::make('observaciones')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
