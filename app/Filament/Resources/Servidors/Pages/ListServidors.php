<?php

namespace App\Filament\Resources\Servidors\Pages;

use App\Filament\Resources\Servidors\ServidorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServidors extends ListRecords
{
    protected static string $resource = ServidorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
