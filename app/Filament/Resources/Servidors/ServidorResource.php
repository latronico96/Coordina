<?php

namespace App\Filament\Resources\Servidors;

use App\Filament\Resources\Servidors\Pages\CreateServidor;
use App\Filament\Resources\Servidors\Pages\EditServidor;
use App\Filament\Resources\Servidors\Pages\ListServidors;
use App\Filament\Resources\Servidors\Pages\ViewServidor;
use App\Filament\Resources\Servidors\Schemas\ServidorForm;
use App\Filament\Resources\Servidors\Schemas\ServidorInfolist;
use App\Filament\Resources\Servidors\Tables\ServidorsTable;
use App\Models\Servidor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServidorResource extends Resource
{
    protected static ?string $model = Servidor::class;

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
            //
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
}
