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
                TextEntry::make('iglesia_id')
                    ->numeric(),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('rol'),
                TextEntry::make('token'),
                TextEntry::make('expires_at')
                    ->dateTime(),
                TextEntry::make('accepted_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
