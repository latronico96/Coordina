<?php

namespace App\Filament\Resources\Invitacions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvitacionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextEntry::make('iglesia.nombre')
                    ->label('Iglesia'),

                TextEntry::make('email')
                    ->label('Email'),

                TextEntry::make('rol')
                    ->badge(),

                TextEntry::make('usuario.name')
                    ->label('Usuario')
                    ->placeholder('-'),

                TextEntry::make('actionToken.token')
                    ->label('Token')
                    ->copyable()
                    ->placeholder('-'),

                TextEntry::make('actionToken.expires_at')
                    ->label('Vencimiento')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('accepted_at')
                    ->label('Aceptada')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
