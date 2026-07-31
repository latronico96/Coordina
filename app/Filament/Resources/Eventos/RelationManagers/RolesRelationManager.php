<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use App\Models\RolServicio;
use App\Models\Evento;
use App\Models\EventoRol;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'rolesRequeridos';

    protected static ?string $title = 'Roles requeridos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('ministerio_id')
                    ->label('Ministerio')
                    ->options(
                        fn () => $this->evento()
                            ->iglesia
                            ->ministerios()
                            ->orderBy('nombre')
                            ->pluck('nombre', 'id')
                    )
                    ->default(
                        fn ($record) => $record?->rolServicio?->ministerio_id
                    )
                    ->searchable()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('rol_servicio_id', null);
                    })
                    ->disabled(
                        fn () => ! $this->evento()->puedeModificarRoles()
                    ),

                Select::make('rol_servicio_id')
                    ->label('Rol')
                    ->options(function (callable $get) {

                        $ministerioId = $get('ministerio_id');

                        if (! $ministerioId) {
                            return [];
                        }

                        return RolServicio::query()
                            ->where('ministerio_id', $ministerioId)
                            ->where('activo', true)
                            ->orderBy('nombre')
                            ->pluck('nombre', 'id');
                    })
                    ->default(
                        fn ($record) => $record?->rol_servicio_id
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->disabled(
                        fn (callable $get) => ! $get('ministerio_id')
                            || ! $this->evento()->puedeModificarRoles()
                    )->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {

                                $query = $this->evento()
                                    ->rolesRequeridos()
                                    ->where('rol_servicio_id', $value);

                                if ($record = $this->getMountedAction()?->getRecord()) {
                                    /** @var EventoRol $record */
                                    $query->whereKeyNot($record->getKey());
                                }

                                if ($query->exists()) {
                                    $fail('Ese rol ya fue agregado al evento.');
                                }
                            };
                        },
                    ]),

                TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required()
                    ->disabled(
                        fn () => ! $this->evento()->puedeModificarRoles()
                    ),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('rolServicio.ministerio.nombre')
            ->columns([

                TextColumn::make('rolServicio.ministerio.nombre')
                    ->label('Ministerio')
                    ->sortable(),

                TextColumn::make('rolServicio.nombre')
                    ->label('Rol')
                    ->sortable(),

                TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('rolServicio.minutos_preparacion')
                    ->label('Preparación')
                    ->formatStateUsing(
                        fn ($state) => $state ? "{$state} min antes" : '-'
                    ),
            ])

            ->recordActions([

                EditAction::make()
                    ->visible(
                        fn () => $this->evento()->puedeModificarRoles()
                    ),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->visible(
                        fn () => $this->evento()->puedeModificarRoles()
                    ),

            ])

            ->headerActions([

                CreateAction::make()
                    ->visible(
                        fn () => $this->evento()->puedeModificarRoles()
                    ),

            ])

            ->paginated(false);
    }

    protected function afterCreate(): void
    {
        $this->evento()->registrarHistorial(
            'rol_agregado',
            'Se agregó un rol requerido al evento.'
        );
    }

    protected function afterSave(): void
    {
        $this->evento()->registrarHistorial(
            'rol_modificado',
            'Se modificó un rol requerido del evento.'
        );
    }

    protected function afterDelete(): void
    {
        $this->evento()->registrarHistorial(
            'rol_eliminado',
            'Se eliminó un rol requerido del evento.'
        );
    }

    protected function evento(): Evento
{
    /** @var Evento $evento */
    $evento = $this->getOwnerRecord();

    return $evento;
}
}
