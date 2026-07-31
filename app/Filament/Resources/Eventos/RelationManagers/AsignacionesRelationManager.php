<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use App\Models\Asignacion;
use App\Models\Evento;
use App\Models\EventoRol;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AsignacionesRelationManager extends RelationManager
{
    protected static string $relationship = 'asignaciones';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('evento_rol_id')
                    ->label('Rol requerido')
                    ->options(function () {
                        return $this->evento()
                            ->rolesRequeridos()
                            ->with([
                                'rolServicio',
                                'asignaciones',
                            ])
                            ->get()
                            ->filter(function ($rol) {
                                return $rol->asignaciones->count() < $rol->cantidad;
                            })
                            ->mapWithKeys(fn ($rol) => [
                                $rol->id => $rol->rolServicio->nombre.
                                    ' ('.
                                    $rol->asignaciones->count().
                                    '/'.
                                    $rol->cantidad.
                                    ')',
                            ]);
                    })
                    ->live()
                    ->afterStateUpdated(fn ($set) => $set('servidor_id', null))
                    ->disabled(
                        fn () => ! $this->evento()->puedeModificarAsignaciones()
                    )
                    ->required(),

                Select::make('servidor_id')
                    ->label('Servidor')
                    ->relationship(
                        'servidor',
                        'nombre',
                        modifyQueryUsing: function ($query, callable $get) {

                            $eventoRolId = $get('evento_rol_id');

                            if (! $eventoRolId) {
                                return $query;
                            }

                            $eventoRol = EventoRol::find($eventoRolId);

                            if (! $eventoRol) {
                                return $query;
                            }

                            return $query
                                ->where('activo', true)
                                ->whereHas(
                                    'rolesServicio',
                                    function ($q) use ($eventoRol) {
                                        $q->where(
                                            'rol_servicio_id',
                                            $eventoRol->rol_servicio_id
                                        );
                                    }
                                )
                                ->orderBy('apellido')
                                ->orderBy('nombre');
                        }
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => $record->nombre.' '.$record->apellido
                    )
                    ->searchable()
                    ->preload()
                    ->disabled(
                        fn () => ! $this->evento()->puedeModificarAsignaciones()
                    )
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {

                                $query = $this->evento()
                                    ->asignaciones()
                                    ->where('servidor_id', $value);

                                if ($record = $this->getMountedAction()?->getRecord()) {
                                    /** @var Asignacion $record */
                                    $query->whereKeyNot($record->getKey());
                                }

                                if ($query->exists()) {
                                    $fail('Ese servidor ya está asignado a este evento.');
                                }
                            };
                        },
                    ])
                    ->required(),

                Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'rechazado' => 'Rechazado',
                    ])
                    ->default('pendiente')
                    ->disabled(
                        fn () => ! $this->evento()->puedeModificarAsignaciones()
                    )
                    ->required(),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['evento_id'] = $this->evento()->id;

        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('servidor.nombre')
                    ->label('Servidor')
                    ->formatStateUsing(
                        fn ($state, $record) => $record->servidor->nombre.
                            ' '.
                            $record->servidor->apellido
                    )
                    ->searchable(),

                TextColumn::make('eventoRol.rolServicio.nombre')
                    ->label('Rol'),

                TextColumn::make('estado')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pendiente' => 'warning',
                        'confirmado' => 'success',
                        'rechazado' => 'danger',
                        default => 'gray',
                    }),

            ])
            ->recordActions([
                EditAction::make()
                    ->after(function () {
                        $this->evento()->registrarHistorial(
                            'asignacion_modificada',
                            'Se modificó una asignación.'
                        );
                    }),
                DeleteAction::make()
                    ->after(function () {
                        $this->evento()->registrarHistorial(
                            'asignacion_eliminada',
                            'Se eliminó una asignación.'
                        );
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->after(function () {
                        $this->evento()->registrarHistorial(
                            'asignacion_agregada',
                            'Se agregó una asignación.'
                        );
                    }),
            ])
            ->defaultSort('estado');
    }

    protected function evento(): Evento
    {
        /** @var Evento $evento */
        $evento = $this->getOwnerRecord();

        return $evento;
    }
}
