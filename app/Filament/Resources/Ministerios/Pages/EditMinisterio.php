<?php

namespace App\Filament\Resources\Ministerios\Pages;

use App\Filament\Resources\Ministerios\MinisterioResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMinisterio extends EditRecord
{
    protected static string $resource = MinisterioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
