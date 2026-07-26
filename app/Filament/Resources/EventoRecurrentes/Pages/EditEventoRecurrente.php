<?php

namespace App\Filament\Resources\EventoRecurrentes\Pages;

use App\Filament\Resources\EventoRecurrentes\EventoRecurrenteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventoRecurrente extends EditRecord
{
    protected static string $resource = EventoRecurrenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
