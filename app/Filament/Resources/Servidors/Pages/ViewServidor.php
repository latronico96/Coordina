<?php

namespace App\Filament\Resources\Servidors\Pages;

use App\Filament\Resources\Servidors\ServidorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServidor extends ViewRecord
{
    protected static string $resource = ServidorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
