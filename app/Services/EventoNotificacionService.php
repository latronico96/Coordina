<?php

namespace App\Services;

use App\Mail\EventoOrganizadoMail;
use App\Models\Evento;
use Illuminate\Support\Facades\Mail;

class EventoNotificacionService
{
    public function notificarServidores(Evento $evento): void
    {
        foreach ($evento->asignaciones as $asignacion) {
            Mail::to(
                $asignacion->servidor->email
            )->send(
                new EventoOrganizadoMail($asignacion)
            );

        }
        $evento->registrarHistorial(
            'evento_organizado',
            'Se enviaron invitaciones a los servidores asignados.'
        );
    }
}
