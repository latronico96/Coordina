<?php

namespace App\Filament\Resources\Invitacions\Pages;

use App\Filament\Resources\Invitacions\InvitacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInvitacions extends ListRecords
{
    protected static string $resource = InvitacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
