<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\EventoRecurrente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventoService
{
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
}
