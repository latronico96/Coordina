<?php

namespace App\Filament\Resources\Iglesias\Pages;

use App\Filament\Resources\Iglesias\IglesiaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIglesia extends ViewRecord
{
    protected static string $resource = IglesiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
