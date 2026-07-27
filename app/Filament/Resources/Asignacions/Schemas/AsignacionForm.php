<?php

namespace App\Filament\Resources\Asignacions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AsignacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('evento_id')
                    ->relationship('evento', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('evento_rol_id')
                    ->relationship('eventoRol', 'id')
                    ->live()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        $record->rolServicio->nombre . ' (x' . $record->cantidad . ')'
                    )
                    ->required(),

                Select::make('servidor_id')
                    ->relationship(
                        'servidor',
                        'nombre',
                        modifyQueryUsing: function ($query, callable $get) {

                            $eventoRolId = $get('evento_rol_id');

                            if (!$eventoRolId) {
                                return $query;
                            }

                            $eventoRol = \App\Models\EventoRol::find($eventoRolId);

                            if (!$eventoRol) {
                                return $query;
                            }

                            return $query->whereHas(
                                'rolesServicio',
                                function ($q) use ($eventoRol) {
                                    $q->where(
                                        'rol_servicio_id',
                                        $eventoRol->rol_servicio_id
                                    );
                                }
                            );
                        }
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        $record->nombre . ' ' . $record->apellido
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'rechazado' => 'Rechazado',
                    ])
                    ->default('pendiente')
                    ->required(),

                Textarea::make('observaciones')
                    ->columnSpanFull(),
            ]);
    }
}
