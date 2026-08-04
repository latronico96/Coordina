<?php

namespace App\Services;

use App\Mail\EventoOrganizadoMail;
use App\Models\ActionToken;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Mail;

class EventoNotificacionService
{
    public function notificarServidor(Asignacion $asignacion, string $url, ActionToken $token): void
    {
        Mail::to(
            $asignacion->servidor->email
        )->send(
            new EventoOrganizadoMail($asignacion, $url, $token)
        );
    }
}
