<?php

namespace App\Filament\Resources\Iglesias\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IglesiaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nombre')
                            ->label('Nombre'),

                        TextEntry::make('direccion')
                            ->label('Dirección')
                            ->placeholder('-'),

                        IconEntry::make('activo')
                            ->label('Activa')
                            ->boolean(),

                        TextEntry::make('created_at')
                            ->label('Creada')
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Última modificación')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),

                Section::make('Identidad')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('logo_url')
                            ->label('Logo')
                            ->imageHeight(80)
                            ->imageWidth(80)
                            ->square()
                            ->placeholder('-'),

                        TextEntry::make('logo_url')
                            ->label('URL del logo')
                            ->copyable()
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->placeholder('-'),

                        ColorEntry::make('color_primario')
                            ->label('Color primario'),

                        ColorEntry::make('color_secundario')
                            ->label('Color secundario'),
                    ]),

                Section::make('Contacto')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('email_contacto')
                            ->label('Email')
                            ->copyable()
                            ->placeholder('-'),

                        TextEntry::make('telefono_contacto')
                            ->label('Teléfono')
                            ->copyable()
                            ->placeholder('-'),
                    ]),

                Section::make('Google Calendar')
                    ->columns(2)
                    ->schema([
                        IconEntry::make('google_calendar_habilitado')
                            ->label('Integración habilitada')
                            ->boolean(),

                        TextEntry::make('google_calendar_id')
                            ->label('Calendar ID')
                            ->copyable()
                            ->placeholder('-')
                            ->visible(
                                fn ($record) => $record->google_calendar_habilitado
                            ),
                    ]),
            ]);
    }
}
