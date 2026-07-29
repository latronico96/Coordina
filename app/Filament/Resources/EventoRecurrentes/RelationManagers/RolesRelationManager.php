<?php

namespace App\Filament\Resources\EventoRecurrentes\RelationManagers;

use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'rolesRequeridos';

    protected static ?string $title = 'Roles requeridos';

    public function form(Schema $schema): Schema
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $schema
            ->components([
                Select::make('rol_servicio_id')
                    ->relationship(
                        'rolServicio',
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
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('cantidad')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rolServicio.nombre')
                    ->label('Rol')
                    ->sortable(),

                TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->alignCenter()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->paginated(false);
    }
}
