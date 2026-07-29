<?php

namespace App\Filament\Resources\RolServicios\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class RolServicioForm
{
    public static function configure(Schema $schema): Schema
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $schema
            ->components([
                Select::make('ministerio_id')
                    ->relationship(
                        'ministerio',
                        'nombre',
                        modifyQueryUsing: fn ($query) => $query->where(
                            'iglesia_id',
                            $user->iglesia_id
                        )
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('minutos_preparacion')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('activo')
                    ->default(true)
                    ->required(),
            ]);
    }
}
