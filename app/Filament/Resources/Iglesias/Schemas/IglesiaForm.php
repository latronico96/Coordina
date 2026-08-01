<?php

namespace App\Filament\Resources\Iglesias\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IglesiaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Datos de la iglesia')
                    ->columns(2)
                    ->schema([

                        TextInput::make('nombre')
                            ->required(),

                        Toggle::make('activo')
                            ->default(true)
                            ->required(),

                        TextInput::make('direccion')
                            ->columnSpanFull(),

                        TextInput::make('email_contacto')
                            ->label('Email de contacto')
                            ->email(),

                        TextInput::make('telefono_contacto')
                            ->label('Teléfono de contacto'),

                    ]),

                Section::make('Identidad visual')
                    ->columns(2)
                    ->schema([

                        TextInput::make('logo_url')
                            ->label('URL del logo')
                            ->url()
                            ->maxLength(500),

                        ColorPicker::make('color_primario')
                            ->default('#2563EB'),

                        ColorPicker::make('color_secundario')
                            ->default('#1E293B'),

                    ]),

                Section::make('Google Calendar')
                    ->columns(2)
                    ->schema([
                        Toggle::make('google_calendar_habilitado')
                            ->label('Habilitar integración')
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if (! $state) {
                                    $set('google_calendar_id', null);
                                }
                            }),
                        TextInput::make('google_calendar_id')
                            ->label('Calendar ID')
                            ->visible(fn ($get) => $get('google_calendar_habilitado'))
                            ->required(fn ($get) => $get('google_calendar_habilitado')),
                    ]),

                Section::make('Administrador inicial')
                    ->description('Se creará un usuario administrador y se le enviará un enlace para establecer su contraseña.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('admin_nombre')
                            ->label('Nombre')
                            ->required(),

                        TextInput::make('admin_email')
                            ->label('Email')
                            ->email()
                            ->required(),
                    ])
                    ->visible(fn (string $operation) => $operation === 'create'),
            ]);
    }
}
