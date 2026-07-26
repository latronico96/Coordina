<?php

namespace App\Filament\Resources\EventoRols\Pages;

use App\Filament\Resources\EventoRols\EventoRolResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventoRol extends ViewRecord
{
    protected static string $resource = EventoRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
