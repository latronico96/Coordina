<?php

namespace App\Filament\Resources\RolServicios\Pages;

use App\Filament\Resources\RolServicios\RolServicioResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRolServicio extends EditRecord
{
    protected static string $resource = RolServicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
