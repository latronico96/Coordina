<?php

namespace App\Filament\Resources\Iglesias\Pages;

use App\Filament\Resources\Iglesias\IglesiaResource;
use App\Services\IglesiaService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateIglesia extends CreateRecord
{
    protected static string $resource = IglesiaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return app(IglesiaService::class)
            ->crearConAdministrador($data);
    }
}
