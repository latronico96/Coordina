<?php

namespace App\Filament\Resources\Ministerios;

use App\Filament\Resources\Ministerios\Pages\CreateMinisterio;
use App\Filament\Resources\Ministerios\Pages\EditMinisterio;
use App\Filament\Resources\Ministerios\Pages\ListMinisterios;
use App\Filament\Resources\Ministerios\Pages\ViewMinisterio;
use App\Filament\Resources\Ministerios\Schemas\MinisterioForm;
use App\Filament\Resources\Ministerios\Schemas\MinisterioInfolist;
use App\Filament\Resources\Ministerios\Tables\MinisteriosTable;
use App\Models\Ministerio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MinisterioResource extends Resource
{
    protected static ?string $model = Ministerio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return MinisterioForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MinisterioInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinisteriosTable::configure($table);
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
            'index' => ListMinisterios::route('/'),
            'create' => CreateMinisterio::route('/create'),
            'view' => ViewMinisterio::route('/{record}'),
            'edit' => EditMinisterio::route('/{record}/edit'),
        ];
    }
}
