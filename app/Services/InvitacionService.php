<?php

namespace App\Services;

use App\Enums\ActionTokenType;
use App\Enums\RolUsuario;
use App\Mail\InvitacionMail;
use App\Models\Iglesia;
use App\Models\Invitacion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvitacionService
{
    public function __construct(
        private readonly ActionTokenService $actionTokenService,
    ) {}

    public function crear(
        Iglesia $iglesia,
        User $user,
        string $rol = RolUsuario::ADMIN_IGLESIA->value,
        int $diasExpiracion = 2,
    ): Invitacion {

        return DB::transaction(function () use (
            $iglesia,
            $user,
            $rol,
            $diasExpiracion,
        ) {

            $invitacion = Invitacion::create([
                'iglesia_id' => $iglesia->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'rol' => $rol,
            ]);

            $this->actionTokenService->crear(
                ActionTokenType::INVITACION,
                user: $user,
                payload: [
                    'invitacion_id' => $invitacion->id,
                ],
                dias: $diasExpiracion,
            );

            return $invitacion;
        });
    }

    public function enviar(Invitacion $invitacion): void
    {
        Mail::to($invitacion->email)
            ->send(new InvitacionMail($invitacion));
    }

    public function crearYEnviar(
        Iglesia $iglesia,
        User $user,
        string $rol = RolUsuario::ADMIN_IGLESIA->value,
        int $diasExpiracion = 2,
    ): Invitacion {

        $invitacion = $this->crear(
            $iglesia,
            $user,
            $rol,
            $diasExpiracion,
        );

        $this->enviar($invitacion);

        return $invitacion;
    }

    public function aceptar(Invitacion $invitacion): void
    {
        $invitacion->update([
            'accepted_at' => now(),
        ]);

        $this->actionTokenService->marcarComoUsado(
            $invitacion->token()
        );
    }

    public function buscarPorToken(string $token): ?Invitacion
    {
        $actionToken = $this->actionTokenService
            ->buscar($token);

        if (! $actionToken) {
            return null;
        }

        $invitacionId = $actionToken->payload['invitacion_id'];

        return Invitacion::with([
            'user',
            'iglesia',
        ])->find($invitacionId);
    }

    public function renovar(
        Invitacion $invitacion,
        int $dias = 2,
    ): Invitacion {

        $this->actionTokenService->renovar(
            $invitacion->token(),
            dias: $dias,
        );

        return $invitacion;
    }

    public function renovarYEnviar(
        Invitacion $invitacion,
        int $dias = 2,
    ): Invitacion {

        $this->renovar(
            $invitacion,
            $dias,
        );

        $this->enviar($invitacion);

        return $invitacion;
    }

    public function valida(Invitacion $invitacion): bool
    {
        $token = $invitacion->token();

        return $token
            && $token->used_at === null
            && $token->expires_at->isFuture();
    }
}
