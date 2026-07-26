<?php

namespace App\Filament\Resources\Servidors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServidorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('iglesia_id')
                    ->relationship('iglesia', 'nombre')
                    ->required(),

                TextInput::make('nombre')
                    ->required(),

                TextInput::make('apellido')
                    ->required(),

                TextInput::make('telefono'),

                TextInput::make('email')
                    ->email(),

                Select::make('rolesServicio')
                    ->relationship('rolesServicio', 'nombre')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Roles de servicio'),

                Toggle::make('activo')
                    ->default(true),
            ]);
    }
}
