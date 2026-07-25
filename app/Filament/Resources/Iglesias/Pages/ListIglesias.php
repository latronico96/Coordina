<?php

namespace App\Filament\Resources\Iglesias\Pages;

use App\Filament\Resources\Iglesias\IglesiaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIglesias extends ListRecords
{
    protected static string $resource = IglesiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
