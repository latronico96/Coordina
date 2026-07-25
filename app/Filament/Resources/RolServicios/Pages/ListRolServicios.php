<?php

namespace App\Filament\Resources\RolServicios\Pages;

use App\Filament\Resources\RolServicios\RolServicioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRolServicios extends ListRecords
{
    protected static string $resource = RolServicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
