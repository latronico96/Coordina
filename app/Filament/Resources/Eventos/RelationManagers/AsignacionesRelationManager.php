<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use App\Filament\Resources\Asignacions\AsignacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class AsignacionesRelationManager extends RelationManager
{
    protected static string $relationship = 'asignaciones';

    protected static ?string $relatedResource = AsignacionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
