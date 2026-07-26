<?php

namespace App\Filament\Resources\EventoRols\Pages;

use App\Filament\Resources\EventoRols\EventoRolResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventoRol extends EditRecord
{
    protected static string $resource = EventoRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
