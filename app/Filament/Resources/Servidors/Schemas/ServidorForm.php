<?php

namespace App\Filament\Resources\Servidors\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ServidorForm
{
    public static function configure(Schema $schema): Schema
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),

                TextInput::make('apellido')
                    ->required(),

                TextInput::make('telefono'),

                TextInput::make('email')
                    ->email(),

                Select::make('rolesServicio')
                    ->relationship('rolesServicio', 'nombre')
                    ->relationship(
                        'rolesServicio',
                        'nombre',
                        modifyQueryUsing: fn ($query) => $query
                            ->orderBy('nombre')
                            ->whereHas(
                                'ministerio',
                                fn (Builder $q) => $q->where(
                                    'iglesia_id',
                                    $user->iglesia_id,
                                ),
                            )
                    )
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Roles de servicio'),

                Toggle::make('activo')
                    ->default(true),
            ]);
    }
}
