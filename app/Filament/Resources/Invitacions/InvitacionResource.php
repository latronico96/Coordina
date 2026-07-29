<?php

namespace App\Filament\Resources\Invitacions;

use App\Filament\Resources\Invitacions\Pages\CreateInvitacion;
use App\Filament\Resources\Invitacions\Pages\EditInvitacion;
use App\Filament\Resources\Invitacions\Pages\ListInvitacions;
use App\Filament\Resources\Invitacions\Pages\ViewInvitacion;
use App\Filament\Resources\Invitacions\Schemas\InvitacionForm;
use App\Filament\Resources\Invitacions\Schemas\InvitacionInfolist;
use App\Filament\Resources\Invitacions\Tables\InvitacionsTable;
use App\Models\Invitacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InvitacionResource extends Resource
{
    protected static ?string $model = Invitacion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'email';

    protected static ?string $navigationLabel = 'Invitaciones';

    protected static ?string $pluralModelLabel = 'Invitaciones';

    protected static ?string $modelLabel = 'Invitación';

    protected static ?int $navigationSort = 1;

    protected static string|UnitEnum|null $navigationGroup = 'Administración';

    public static function form(Schema $schema): Schema
    {
        return InvitacionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvitacionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvitacionsTable::configure($table);
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
            'index' => ListInvitacions::route('/'),
            'create' => CreateInvitacion::route('/create'),
            'view' => ViewInvitacion::route('/{record}'),
            'edit' => EditInvitacion::route('/{record}/edit'),
        ];
    }
}
