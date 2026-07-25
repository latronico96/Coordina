<?php

namespace App\Filament\Resources\RolServicios\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RolServicioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ministerio_id')
                    ->numeric(),
                TextEntry::make('nombre'),
                TextEntry::make('minutos_preparacion')
                    ->numeric(),
                IconEntry::make('activo')
                    ->boolean(),
            ]);
    }
}
