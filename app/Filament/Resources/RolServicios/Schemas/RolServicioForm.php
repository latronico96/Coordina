<?php

namespace App\Filament\Resources\RolServicios\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RolServicioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ministerio_id')
                    ->relationship('ministerio', 'nombre')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('minutos_preparacion')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
