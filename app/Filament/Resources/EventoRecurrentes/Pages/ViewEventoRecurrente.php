<?php

namespace App\Filament\Resources\EventoRecurrentes\Pages;

use App\Filament\Resources\EventoRecurrentes\EventoRecurrenteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventoRecurrente extends ViewRecord
{
    protected static string $resource = EventoRecurrenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
