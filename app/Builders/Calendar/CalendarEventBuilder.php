<?php

namespace App\Builders\Calendar;

use App\DTO\Calendar\CalendarEventData;
use App\Models\Evento;
use Carbon\Carbon;

class CalendarEventBuilder
{
    public static function fromEvento(Evento $evento): CalendarEventData
    {
        $inicio = Carbon::parse(
            $evento->fecha->format('Y-m-d').' '.$evento->hora_inicio
        );
        $fin = $inicio->copy()->addHours(2);

        return CalendarEventData::make()
            ->summary($evento->nombre)
            ->description(
                self::descripcion($evento)
            )
            ->location(
                $evento->iglesia->direccion
            )
            ->start(
                $inicio->toIso8601String()
            )
            ->end(
                $fin->toIso8601String()
            )
            ->emails(
                self::emails($evento)
            );
    }

    private static function emails(Evento $evento): array
    {
        return $evento->asignaciones
            ->pluck('servidor.email')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private static function descripcion(Evento $evento): string
    {
        $lineas = [];

        $lineas[] = $evento->nombre;
        $lineas[] = '';

        $lineas[] = 'Fecha: '.
            $evento->fecha->format('d/m/Y');

        $lineas[] = 'Hora: '.
            $evento->hora_inicio;

        if ($evento->iglesia->direccion) {
            $lineas[] = 'Lugar: '.
                $evento->iglesia->direccion;
        }

        $lineas[] = '';
        $lineas[] = 'Asignaciones';
        $lineas[] = '';

        foreach ($evento->rolesRequeridos as $rol) {

            $lineas[] = '• '.$rol->rolServicio->nombre;

            foreach ($rol->asignaciones as $asignacion) {
                $servidor = $asignacion->servidor;
                $lineas[] =
                    '    - '.
                    $servidor->nombre.
                    ' '.
                    $servidor->apellido;
            }
            $lineas[] = '';
        }
        $lineas[] = 'Generado automáticamente por Coordina.';

        return implode("\n", $lineas);
    }
}
