<?php

namespace App\Filament\Resources\Eventos\Pages;

use App\Filament\Resources\Eventos\EventoResource;
use App\Models\Evento;
use App\Services\EventoService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEvento extends ViewRecord
{
    protected static string $resource = EventoResource::class;

    protected function getHeaderActions(): array
    {

        /** @var Evento $evento */
        $evento = $this->record;

        return [
            EditAction::make(),
            Action::make('organizar')
                ->visible(fn () => $evento->puedeOrganizar())
                ->action(fn () => app(EventoService::class)->organizar($evento))
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Action::make('realizar')
                ->visible(fn () => $evento->puedeRealizar())
                ->action(fn () => app(EventoService::class)->realizar($evento)),

            Action::make('cancelar')
                ->requiresConfirmation()
                ->visible(fn () => $evento->puedeCancelar())
                ->action(fn () => app(EventoService::class)->cancelar($evento)),
        ];
    }
}
