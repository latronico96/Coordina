<?php

namespace App\Services;

use App\Builders\Calendar\CalendarEventBuilder;
use App\Enums\EstadoEvento;
use App\Models\Evento;
use App\Models\EventoRecurrente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventoService
{
    public function __construct(
        private readonly GoogleCalendarService $googleCalendar,
        private readonly InvitacionService $invitacionService,
    ) {}

    public function crearDesdeRecurrente(
        EventoRecurrente $eventoRecurrente,
        Carbon $fecha
    ): Evento {
        return DB::transaction(function () use ($eventoRecurrente, $fecha) {

            $evento = Evento::create([
                'iglesia_id' => $eventoRecurrente->iglesia_id,
                'evento_recurrente_id' => $eventoRecurrente->id,
                'nombre' => $eventoRecurrente->nombre,
                'fecha' => $fecha,
                'hora_inicio' => $eventoRecurrente->hora_inicio,
                'estado' => 'pendiente',
            ]);

            foreach ($eventoRecurrente->rolesRequeridos as $rol) {
                $evento->rolesRequeridos()->create([
                    'rol_servicio_id' => $rol->rol_servicio_id,
                    'cantidad' => $rol->cantidad,
                ]);
            }

            return $evento;
        });
    }

    public function organizar(Evento $evento): void
    {
        if (! $evento->puedeOrganizar()) {
            abort(403);
        }
        $evento->update([
            'estado' => EstadoEvento::ORGANIZADO,
        ]);
        $evento->registrarHistorial(
            'organizado',
            'Evento organizado.'
        );

        app(EventoNotificacionService::class)
            ->notificarServidores($evento);
        $this->crearEventoCalendario($evento);
    }

    public function realizar(Evento $evento): void
    {
        if (! $evento->puedeRealizar()) {
            abort(403);
        }
        $evento->update([
            'estado' => EstadoEvento::REALIZADO,
        ]);
        $evento->registrarHistorial(
            'realizado',
            'Evento marcado como realizado.'
        );
    }

    public function cancelar(Evento $evento): void
    {
        if (! $evento->puedeCancelar()) {
            abort(403);
        }

        $evento->update([
            'estado' => EstadoEvento::CANCELADO,
        ]);

        $evento->registrarHistorial(
            'cancelado',
            'Evento cancelado.'
        );
    }

    private function crearEventoCalendario(Evento $evento): void
    {
        if ($evento->iglesia->google_calendar_habilitado && $evento->iglesia->google_calendar_id)
        {
            $calendarEvent = CalendarEventBuilder::fromEvento($evento);
            $googleId = $this->googleCalendar->crearEvento(
                $evento->iglesia->google_calendar_id,
                $calendarEvent
            );
            $evento->update([
                'google_calendar_event_id' => $googleId,
            ]);
        }
    }
}
