<?php

namespace App\Services;

use App\Enums\ActionTokenType;
use App\Models\ActionToken;
use App\Models\AsignacionConfirmacion;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AsignacionConfirmacionService
{
    public function __construct(
        private readonly ActionTokenService $actionTokenService,
    ) {}

    public function crear(
        AsignacionConfirmacion $confirmacion,
        User $user,
        int $diasExpiracion = 2,
    ): ActionToken {

        return $this->actionTokenService->crear(
            ActionTokenType::CONFIRMAR_ASIGNACION,
            user: $user,
            payload: [
                'asignacion_confirmacion_id' => $confirmacion->id,
            ],
            dias: $diasExpiracion,
        );
    }

    public function buscarPorActionToken(
        ActionToken $token,
    ): ?AsignacionConfirmacion {

        $id = $token->payload['asignacion_confirmacion_id'] ?? null;

        if (! $id) {
            return null;
        }

        return AsignacionConfirmacion::query()
            ->with([
                'asignacion',
                'usuario',
            ])
            ->find($id);
    }

    public function responder(
        AsignacionConfirmacion $confirmacion,
        string $respuesta,
    ): void {

        DB::transaction(function () use (
            $confirmacion,
            $respuesta
        ) {

            $confirmacion->update([
                'respuesta' => $respuesta,
                'respondido_at' => now(),
            ]);

            if ($respuesta === 'confirmado') {

                $confirmacion
                    ->asignacion
                    ->update([
                        'estado' => 'confirmada',
                    ]);
            }

            if ($respuesta === 'rechazado') {

                $confirmacion
                    ->asignacion
                    ->update([
                        'estado' => 'rechazada',
                    ]);
            }

        });
    }

    public function valida(
        AsignacionConfirmacion $confirmacion,
    ): bool {

        return $confirmacion->respondido_at === null;
    }
}
