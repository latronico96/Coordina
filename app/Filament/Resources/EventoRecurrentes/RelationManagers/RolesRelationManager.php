<?php

namespace App\Filament\Resources\EventoRecurrentes\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('rol_servicio_id')
                    ->relationship('rolServicio', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('cantidad')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rolServicio.nombre')
                    ->label('Rol'),

                TextColumn::make('cantidad')
                    ->label('Cantidad'),
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
