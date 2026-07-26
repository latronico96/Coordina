<?php

namespace App\Filament\Resources\EventoRecurrentes;

use App\Filament\Resources\EventoRecurrentes\Pages\CreateEventoRecurrente;
use App\Filament\Resources\EventoRecurrentes\Pages\EditEventoRecurrente;
use App\Filament\Resources\EventoRecurrentes\Pages\ListEventoRecurrentes;
use App\Filament\Resources\EventoRecurrentes\Pages\ViewEventoRecurrente;
use App\Filament\Resources\EventoRecurrentes\RelationManagers\RolesRelationManager;
use App\Filament\Resources\EventoRecurrentes\Schemas\EventoRecurrenteForm;
use App\Filament\Resources\EventoRecurrentes\Schemas\EventoRecurrenteInfolist;
use App\Filament\Resources\EventoRecurrentes\Tables\EventoRecurrentesTable;
use App\Models\EventoRecurrente;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventoRecurrenteResource extends Resource
{
    protected static ?string $model = EventoRecurrente::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return EventoRecurrenteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventoRecurrenteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventoRecurrentesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventoRecurrentes::route('/'),
            'create' => CreateEventoRecurrente::route('/create'),
            'view' => ViewEventoRecurrente::route('/{record}'),
            'edit' => EditEventoRecurrente::route('/{record}/edit'),
        ];
    }
}
