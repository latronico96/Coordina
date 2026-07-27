<?php

namespace App\Filament\Resources\Asignacions\Pages;

use App\Filament\Resources\Asignacions\AsignacionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAsignacion extends EditRecord
{
    protected static string $resource = AsignacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
