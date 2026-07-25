<?php

namespace App\Filament\Resources\Iglesias;

use App\Filament\Resources\Iglesias\Pages\CreateIglesia;
use App\Filament\Resources\Iglesias\Pages\EditIglesia;
use App\Filament\Resources\Iglesias\Pages\ListIglesias;
use App\Filament\Resources\Iglesias\Pages\ViewIglesia;
use App\Filament\Resources\Iglesias\Schemas\IglesiaForm;
use App\Filament\Resources\Iglesias\Schemas\IglesiaInfolist;
use App\Filament\Resources\Iglesias\Tables\IglesiasTable;
use App\Models\Iglesia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IglesiaResource extends Resource
{
    protected static ?string $model = Iglesia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return IglesiaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IglesiaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IglesiasTable::configure($table);
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
            'index' => ListIglesias::route('/'),
            'create' => CreateIglesia::route('/create'),
            'view' => ViewIglesia::route('/{record}'),
            'edit' => EditIglesia::route('/{record}/edit'),
        ];
    }
}
