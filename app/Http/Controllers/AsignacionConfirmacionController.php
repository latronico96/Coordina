<?php

namespace App\Http\Controllers;

use App\Services\ActionTokenService;
use App\Services\AsignacionConfirmacionService;
use Illuminate\Http\Request;

class AsignacionConfirmacionController extends Controller
{
    public function mostrar(
        string $token,
        ActionTokenService $actionTokenService,
        AsignacionConfirmacionService $service,
    ) {
        $actionToken = $actionTokenService->buscar($token);

        if (! $actionToken || ! $actionTokenService->valido($actionToken)) {
            abort(404);
        }

        $confirmacion = $service->buscarPorActionToken($actionToken);

        if (! $confirmacion) {
            abort(404);
        }

        return view('asignaciones.confirmar', [
            'confirmacion' => $confirmacion,
        ]);
    }

    public function confirmar(
        Request $request,
        string $token,
        ActionTokenService $actionTokenService,
        AsignacionConfirmacionService $service,
    ) {
        $actionToken = $actionTokenService->buscar($token);

        if (! $actionToken || ! $actionTokenService->valido($actionToken)) {
            abort(404);
        }

        $confirmacion = $service->buscarPorActionToken($actionToken);

        if (! $confirmacion) {
            abort(404);
        }

        $request->validate([
            'respuesta' => ['required', 'in:confirmado,rechazado'],
        ]);

        $service->responder(
            $confirmacion,
            $request->string('respuesta')->toString(),
        );

        $actionTokenService->marcarComoUsado($actionToken);

        return view('asignaciones.confirmada', [
            'respuesta' => $request->string('respuesta')->toString(),
        ]);
    }
}
