<?php

namespace App\Filament\Resources\RolServicios\Pages;

use App\Filament\Resources\RolServicios\RolServicioResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRolServicio extends ViewRecord
{
    protected static string $resource = RolServicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
