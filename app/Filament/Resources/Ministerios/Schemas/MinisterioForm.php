<?php

namespace App\Filament\Resources\Ministerios\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MinisterioForm
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
                TextInput::make('descripcion')
                    ->required(),
                Toggle::make('activo')
                    ->default(true)
                    ->required(),
            ]);
    }
}
