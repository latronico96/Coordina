<?php

namespace App\Filament\Resources\Invitacions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvitacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->unique(ignoreRecord: true)
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('rol')
                    ->required(),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
