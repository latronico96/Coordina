<?php

namespace App\Filament\Resources\EventoRols\Pages;

use App\Filament\Resources\EventoRols\EventoRolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventoRols extends ListRecords
{
    protected static string $resource = EventoRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
