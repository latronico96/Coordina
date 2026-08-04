<?php

namespace App\Http\Controllers;

use App\Services\AsignacionService;

class AsignacionController extends Controller
{
    public function mostrar(
        string $token,
        AsignacionService $service,
    ) {
        $asignacion = $service->buscarPorToken($token);

        if (! $asignacion) {
            abort(404);
        }

        return view('asignaciones.confirmar', [
            'asignacion' => $asignacion,
            'token' => $token,
        ]);
    }

    public function confirmar(
        string $token,
        AsignacionService $service,
    ) {
        $service->confirmarDesdeToken($token);

        return view('asignaciones.resultado', [
            'titulo' => '¡Gracias!',
            'mensaje' => 'Tu asistencia fue confirmada.',
        ]);
    }

    public function rechazar(
        string $token,
        AsignacionService $service,
    ) {
        $service->rechazarDesdeToken($token);

        return view('asignaciones.resultado', [
            'titulo' => 'Respuesta registrada',
            'mensaje' => 'Se informó que no podrás asistir.',
        ]);
    }
}
