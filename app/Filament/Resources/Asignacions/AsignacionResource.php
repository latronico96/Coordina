<?php

namespace App\Filament\Resources\Asignacions;

use App\Filament\Resources\Asignacions\Pages\CreateAsignacion;
use App\Filament\Resources\Asignacions\Pages\EditAsignacion;
use App\Filament\Resources\Asignacions\Pages\ListAsignacions;
use App\Filament\Resources\Asignacions\Pages\ViewAsignacion;
use App\Filament\Resources\Asignacions\Schemas\AsignacionForm;
use App\Filament\Resources\Asignacions\Schemas\AsignacionInfolist;
use App\Filament\Resources\Asignacions\Tables\AsignacionsTable;
use App\Filament\Resources\EntidadDeIglesiaResource;
use App\Models\Asignacion;
use App\Models\User;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AsignacionResource extends EntidadDeIglesiaResource
{
    protected static function aplicarFiltroIglesia(
        Builder $query,
        User $user,
    ): Builder {
        return $query->whereHas(
            'evento',
            fn (Builder $q) => $q->where(
                'iglesia_id',
                $user->iglesia_id,
            ),
        );
    }

    protected static string|UnitEnum|null $navigationGroup = 'Eventos';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Asignaciones';

    protected static ?string $model = Asignacion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return AsignacionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AsignacionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AsignacionsTable::configure($table);
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
            'index' => ListAsignacions::route('/'),
            'create' => CreateAsignacion::route('/create'),
            'view' => ViewAsignacion::route('/{record}'),
            'edit' => EditAsignacion::route('/{record}/edit'),
        ];
    }
}
