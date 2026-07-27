<?php

namespace App\Filament\Resources\Asignacions\Pages;

use App\Filament\Resources\Asignacions\AsignacionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAsignacion extends ViewRecord
{
    protected static string $resource = AsignacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
