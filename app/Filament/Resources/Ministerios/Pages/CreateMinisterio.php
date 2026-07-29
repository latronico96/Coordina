<?php

namespace App\Filament\Resources\Ministerios\Pages;

use App\Filament\Resources\Ministerios\MinisterioResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMinisterio extends CreateRecord
{
    protected static string $resource = MinisterioResource::class;

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
