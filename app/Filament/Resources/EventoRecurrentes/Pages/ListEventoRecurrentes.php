<?php

namespace App\Filament\Resources\EventoRecurrentes\Pages;

use App\Filament\Resources\EventoRecurrentes\EventoRecurrenteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventoRecurrentes extends ListRecords
{
    protected static string $resource = EventoRecurrenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
