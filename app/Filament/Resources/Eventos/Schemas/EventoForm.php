<?php

namespace App\Filament\Resources\Eventos\Schemas;

use App\Models\EventoRecurrente;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $schema
            ->components([
                Select::make('evento_recurrente_id')
                    ->label('Plantilla')
                    ->live()
                    ->searchable()
                    ->preload()
                    ->placeholder('Sin plantilla')
                    ->relationship(
                        'eventoRecurrente',
                        'nombre',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->where('iglesia_id', $user->iglesia_id)
                            ->orderBy('nombre')
                    )->afterStateUpdated(function ($state, Set $set) {
                        if (! $state) {
                            $set('nombre', null);
                            $set('hora_inicio', null);
                            $set('estado', 'pendiente');
                            $set('fecha', null);

                            return;
                        }

                        $plantilla = EventoRecurrente::find($state);

                        if (! $plantilla) {
                            return;
                        }

                        $fecha = now()->next(match ($plantilla->dia_semana) {
                            1 => Carbon::MONDAY,
                            2 => Carbon::TUESDAY,
                            3 => Carbon::WEDNESDAY,
                            4 => Carbon::THURSDAY,
                            5 => Carbon::FRIDAY,
                            6 => Carbon::SATURDAY,
                            7 => Carbon::SUNDAY,
                        });

                        $set('nombre', $plantilla->nombre);
                        $set('hora_inicio', $plantilla->hora_inicio);
                        $set('estado', 'pendiente');
                        $set('fecha', $fecha->toDateString());
                    }),

                TextInput::make('nombre')
                    ->required(),

                DatePicker::make('fecha')
                    ->required(),

                TimePicker::make('hora_inicio')
                    ->required(),

                Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'realizado' => 'Realizado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default('pendiente')
                    ->required(),
            ]);
    }
}
