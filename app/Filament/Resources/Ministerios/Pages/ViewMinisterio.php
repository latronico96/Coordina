<?php

namespace App\Filament\Resources\Ministerios\Pages;

use App\Filament\Resources\Ministerios\MinisterioResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMinisterio extends ViewRecord
{
    protected static string $resource = MinisterioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
