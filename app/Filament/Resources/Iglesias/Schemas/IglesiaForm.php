<?php

namespace App\Filament\Resources\Iglesias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class IglesiaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('nombre')
                    ->required(),

                TextInput::make('direccion'),

                Toggle::make('activo')
                    ->default(true)
                    ->required(),

                TextInput::make('admin_nombre')
                    ->label('Nombre administrador')
                    ->required()
                    ->live(),

                TextInput::make('admin_email')
                    ->label('Email administrador')
                    ->email()
                    ->required(),

            ]);
    }
}
