<?php

namespace App\Filament\Resources\Invitacions\Pages;

use App\Filament\Resources\Invitacions\InvitacionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvitacion extends EditRecord
{
    protected static string $resource = InvitacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
