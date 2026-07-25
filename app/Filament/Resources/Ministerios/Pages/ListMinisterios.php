<?php

namespace App\Filament\Resources\Ministerios\Pages;

use App\Filament\Resources\Ministerios\MinisterioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMinisterios extends ListRecords
{
    protected static string $resource = MinisterioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
