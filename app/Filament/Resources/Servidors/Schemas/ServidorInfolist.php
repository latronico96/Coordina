<?php

namespace App\Filament\Resources\Servidors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServidorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Datos del servidor')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([

                        TextEntry::make('nombre'),

                        TextEntry::make('apellido'),

                        TextEntry::make('email')
                            ->placeholder('-'),

                        TextEntry::make('telefono')
                            ->placeholder('-'),

                        TextEntry::make('activo')
                            ->badge()
                            ->label('Estado')
                            ->formatStateUsing(fn (bool $state) => $state ? 'Activo' : 'Inactivo')
                            ->color(fn (bool $state) => $state ? 'success' : 'danger'),

                    ]),

                Section::make('Usuario de Coordina')
                    ->icon('heroicon-o-user-circle')
                    ->description('Acceso a la plataforma')
                    ->visible(fn ($record) => $record->tieneUsuario())
                    ->columns(2)
                    ->schema([

                        TextEntry::make('user.email')
                            ->label('Usuario'),

                        TextEntry::make('estado_usuario')
                            ->label('Estado')
                            ->badge()
                            ->color(function ($record) {
                                return $record->usuarioActivo()
                                    ? 'success'
                                    : 'warning';
                            })
                            ->state(function ($record) {

                                if ($record->user->activated_at) {
                                    return 'Activo';
                                }

                                return 'Invitación pendiente';
                            }),

                    ]),

                Section::make('Sin usuario')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->visible(fn ($record) => ! $record->tieneUsuario())
                    ->schema([

                        TextEntry::make('sin_usuario')
                            ->hiddenLabel()
                            ->state('Este servidor todavía no posee un usuario para ingresar a Coordina.'),

                    ]),

                Section::make('Roles de servicio')
                    ->icon('heroicon-o-users')
                    ->schema([

                        TextEntry::make('rolesServicio.nombre')
                            ->badge()
                            ->separator(','),

                    ]),

                Section::make('Actividad')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(3)
                    ->schema([

                        TextEntry::make('asignaciones_count')
                            ->label('Asignaciones')
                            ->counts('asignaciones'),

                        TextEntry::make('created_at')
                            ->label('Creado')
                            ->date(),

                        TextEntry::make('updated_at')
                            ->label('Última modificación')
                            ->since(),

                    ]),

            ]);
    }
}
