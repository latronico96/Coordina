<?php

namespace App\Filament\Resources\EventoRecurrentes\RelationManagers;

use App\Models\EventoRecurrente;
use App\Models\RolServicio;
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
                        fn () => $this->eventoRecurrente()
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
                    ->afterStateUpdated(fn ($set) => $set('rol_servicio_id', null)),

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
                    ->required()
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {

                                $query = $this->eventoRecurrente()
                                    ->rolesRequeridos()
                                    ->where('rol_servicio_id', $value);

                                if ($record = $this->getMountedAction()?->getRecord()) {
                                    $query->whereKeyNot($record->getKey());
                                }

                                if ($query->exists()) {
                                    $fail('Ese rol ya fue agregado a la plantilla.');
                                }
                            };
                        },
                    ]),

                TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
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
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->paginated(false);
    }

    protected function eventoRecurrente(): EventoRecurrente
    {
        /** @var EventoRecurrente $evento */
        $evento = $this->getOwnerRecord();

        return $evento;
    }
}
