<?php

namespace App\Filament\Resources\Eventos\Pages;

use App\Filament\Resources\Eventos\EventoResource;
use App\Models\Evento;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEvento extends CreateRecord
{
    protected static string $resource = EventoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var User|null $user */
        $user = Auth::user();
        $data['iglesia_id'] = $user
            ? $user->iglesia_id
            : null;

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var Evento $evento */
        $evento = $this->record;
        $evento->registrarHistorial(
            'creado',
            'Evento creado'
        );
    }
}
