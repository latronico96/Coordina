<?php

namespace App\Filament\Resources\Invitacions\Pages;

use App\Filament\Resources\Invitacions\InvitacionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvitacion extends ViewRecord
{
    protected static string $resource = InvitacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
