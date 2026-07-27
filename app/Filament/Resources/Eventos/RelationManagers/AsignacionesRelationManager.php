<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

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
                        return $this->ownerRecord
                            ->rolesRequeridos()
                            ->with('rolServicio')
                            ->get()
                            ->mapWithKeys(fn($rol) => [
                                $rol->id =>
                                $rol->rolServicio->nombre .
                                    ' (x' . $rol->cantidad . ')'
                            ]);
                    })
                    ->live()
                    ->afterStateUpdated(fn($set) => $set('servidor_id', null))
                    ->required(),


                Select::make('servidor_id')
                    ->label('Servidor')
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
            ]);
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['evento_id'] = $this->ownerRecord->id;

        return $data;
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('servidor.nombre')
                    ->label('Servidor'),

                TextColumn::make('servidor.apellido')
                    ->label('Apellido'),

                TextColumn::make('eventoRol.rolServicio.nombre')
                    ->label('Rol'),

                TextColumn::make('estado')
                    ->badge(),

            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
