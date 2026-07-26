<?php

namespace App\Filament\Resources\Servidors\Pages;

use App\Filament\Resources\Servidors\ServidorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditServidor extends EditRecord
{
    protected static string $resource = ServidorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
