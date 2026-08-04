<?php

namespace App\Services;

use App\Enums\ActionTokenType;
use App\Enums\EstadoAsignacion;
use App\Models\ActionToken;
use App\Models\Asignacion;

class AsignacionService
{
    public function __construct(
        private readonly ActionTokenService $actionTokenService,
        private readonly EventoNotificacionService $eventoNotificacionService,
    ) {}

    public function enviarConfirmacion(Asignacion $asignacion): ActionToken
    {
        return $this->actionTokenService->crear(
            ActionTokenType::CONFIRMAR_ASIGNACION,
            user: $asignacion->servidor->user,
            payload: [
                'asignacion_id' => $asignacion->id,
            ],
            dias: 2,
        );
    }

    public function buscarPorToken(string $token): ?Asignacion
    {
        $actionToken = $this->actionTokenService->buscar($token);

        if (! $actionToken || ! $actionToken->valido()) {
            return null;
        }

        return Asignacion::find(
            $actionToken->payload['asignacion_id']
        );
    }

    public function confirmarDesdeToken(string $token): void
    {
        $actionToken = $this->actionTokenService->buscar($token);

        if (! $actionToken || ! $actionToken->valido()) {
            abort(404);
        }

        $asignacion = Asignacion::findOrFail(
            $actionToken->payload['asignacion_id']
        );

        $this->confirmar($asignacion);
    }

    public function rechazarDesdeToken(string $token): void
    {
        $actionToken = $this->actionTokenService->buscar($token);

        if (! $actionToken || ! $actionToken->valido()) {
            abort(404);
        }

        $asignacion = Asignacion::findOrFail(
            $actionToken->payload['asignacion_id']
        );

        $this->rechazar($asignacion);
    }

    public function confirmar(Asignacion $asignacion): void
    {
        $asignacion->update([
            'estado' => EstadoAsignacion::CONFIRMADO,
            'confirmado_at' => now(),
        ]);

        $this->actionTokenService->revocarPorPayload(
            ActionTokenType::CONFIRMAR_ASIGNACION,
            'asignacion_id',
            $asignacion->id,
        );

        $asignacion->evento->registrarHistorial(
            'asignacion_confirmada',
            "{$asignacion->servidor->nombre} confirmó asistencia."
        );
    }

    public function rechazar(Asignacion $asignacion): void
    {
        $asignacion->update([
            'estado' => EstadoAsignacion::RECHAZADO,
            'rechazado_at' => now(),
        ]);

        $this->actionTokenService->revocarPorPayload(
            ActionTokenType::CONFIRMAR_ASIGNACION,
            'asignacion_id',
            $asignacion->id,
        );

        $asignacion->evento->registrarHistorial(
            'asignacion_rechazada',
            "{$asignacion->servidor->nombre} rechazó la asignación."
        );
    }
}
