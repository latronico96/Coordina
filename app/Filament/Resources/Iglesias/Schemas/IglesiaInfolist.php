<?php

namespace App\Filament\Resources\Iglesias\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class IglesiaInfolist
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
                TextEntry::make('nombre'),
                TextEntry::make('direccion')
                    ->placeholder('-'),
                IconEntry::make('activo')
                    ->boolean(),
            ]);
    }
}
