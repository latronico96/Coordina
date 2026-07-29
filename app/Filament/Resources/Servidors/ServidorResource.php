<?php

namespace App\Filament\Resources\Servidors;

use App\Filament\Resources\EntidadDeIglesiaResource;
use App\Filament\Resources\Servidors\Pages\CreateServidor;
use App\Filament\Resources\Servidors\Pages\EditServidor;
use App\Filament\Resources\Servidors\Pages\ListServidors;
use App\Filament\Resources\Servidors\Pages\ViewServidor;
use App\Filament\Resources\Servidors\RelationManagers\DisponibilidadesRelationManager;
use App\Filament\Resources\Servidors\Schemas\ServidorForm;
use App\Filament\Resources\Servidors\Schemas\ServidorInfolist;
use App\Filament\Resources\Servidors\Tables\ServidorsTable;
use App\Models\Servidor;
use App\Models\User;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ServidorResource extends EntidadDeIglesiaResource
{
    protected static ?string $model = Servidor::class;

    protected static string|UnitEnum|null $navigationGroup = 'Servidores';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Servidores';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return ServidorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServidorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServidorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DisponibilidadesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServidors::route('/'),
            'create' => CreateServidor::route('/create'),
            'view' => ViewServidor::route('/{record}'),
            'edit' => EditServidor::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user?->hasAnyRole([
            'admin-iglesia',
            'coordinador',
            'lider-ministerio',
        ]);
    }
}
