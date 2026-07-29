<?php

namespace App\Filament\Resources\RolServicios;

use App\Filament\Resources\EntidadDeIglesiaResource;
use App\Filament\Resources\RolServicios\Pages\CreateRolServicio;
use App\Filament\Resources\RolServicios\Pages\EditRolServicio;
use App\Filament\Resources\RolServicios\Pages\ListRolServicios;
use App\Filament\Resources\RolServicios\Pages\ViewRolServicio;
use App\Filament\Resources\RolServicios\Schemas\RolServicioForm;
use App\Filament\Resources\RolServicios\Schemas\RolServicioInfolist;
use App\Filament\Resources\RolServicios\Tables\RolServiciosTable;
use App\Models\RolServicio;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RolServicioResource extends EntidadDeIglesiaResource
{
    protected static ?string $model = RolServicio::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Roles de Servicio';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return RolServicioForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RolServicioInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolServiciosTable::configure($table);
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
            'index' => ListRolServicios::route('/'),
            'create' => CreateRolServicio::route('/create'),
            'view' => ViewRolServicio::route('/{record}'),
            'edit' => EditRolServicio::route('/{record}/edit'),
        ];
    }
}
