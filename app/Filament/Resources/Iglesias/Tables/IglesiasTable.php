<?php

namespace App\Filament\Resources\Iglesias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IglesiasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre'),
                IconColumn::make('activo')
                    ->boolean(),
                IconColumn::make('google_calendar_habilitado')
                    ->label('Calendar')
                    ->boolean(),
                TextColumn::make('usuarios_count')
                    ->counts('usuarios')
                    ->label('Usuarios'),
                TextColumn::make('ministerios_count')
                    ->counts('ministerios')
                    ->label('Ministerios'),
                TextColumn::make('servidores_count')
                    ->counts('servidores')
                    ->label('Servidores'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
