<?php

namespace App\Filament\Resources\Eventos;

use App\Enums\RolUsuario;
use App\Filament\Resources\EntidadDeIglesiaResource;
use App\Filament\Resources\Eventos\Pages\CreateEvento;
use App\Filament\Resources\Eventos\Pages\EditEvento;
use App\Filament\Resources\Eventos\Pages\ListEventos;
use App\Filament\Resources\Eventos\Pages\ViewEvento;
use App\Filament\Resources\Eventos\RelationManagers\AsignacionesRelationManager;
use App\Filament\Resources\Eventos\RelationManagers\HistorialRelationManager;
use App\Filament\Resources\Eventos\RelationManagers\RolesRelationManager;
use App\Filament\Resources\Eventos\Schemas\EventoForm;
use App\Filament\Resources\Eventos\Schemas\EventoInfolist;
use App\Filament\Resources\Eventos\Tables\EventosTable;
use App\Models\Evento;
use App\Models\User;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class EventoResource extends EntidadDeIglesiaResource
{
    protected static string|UnitEnum|null $navigationGroup = 'Eventos';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Eventos';

    protected static ?string $model = Evento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return EventoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
            AsignacionesRelationManager::class,
            HistorialRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventos::route('/'),
            'create' => CreateEvento::route('/create'),
            'view' => ViewEvento::route('/{record}'),
            'edit' => EditEvento::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user?->hasAnyRole(RolUsuario::coordinacion());
    }
}
