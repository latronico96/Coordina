<?php

namespace App\Filament\Resources\EventoRecurrentes\Pages;

use App\Filament\Resources\EventoRecurrentes\EventoRecurrenteResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEventoRecurrente extends CreateRecord
{
    protected static string $resource = EventoRecurrenteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var User|null $user */
        $user = Auth::user();
        $data['iglesia_id'] = $user
            ? $user->iglesia_id
            : null;

        return $data;
    }
}
