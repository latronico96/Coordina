<?php

namespace App\Filament\Resources\EventoRols;

use App\Filament\Resources\EventoRols\Pages\CreateEventoRol;
use App\Filament\Resources\EventoRols\Pages\EditEventoRol;
use App\Filament\Resources\EventoRols\Pages\ListEventoRols;
use App\Filament\Resources\EventoRols\Pages\ViewEventoRol;
use App\Filament\Resources\EventoRols\Schemas\EventoRolForm;
use App\Filament\Resources\EventoRols\Schemas\EventoRolInfolist;
use App\Filament\Resources\EventoRols\Tables\EventoRolsTable;
use App\Models\EventoRol;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventoRolResource extends Resource
{
    protected static ?string $model = EventoRol::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return EventoRolForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventoRolInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventoRolsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventoRols::route('/'),
            'create' => CreateEventoRol::route('/create'),
            'view' => ViewEventoRol::route('/{record}'),
            'edit' => EditEventoRol::route('/{record}/edit'),
        ];
    }
}
