<?php

namespace App\Services;

use App\Mail\InvitacionMail;
use App\Models\Iglesia;
use App\Models\Invitacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;

class InvitacionService
{
    public function crear(
        Iglesia $iglesia,
        User $user,
        string $rol = 'admin-iglesia',
        int $diasExpiracion = 2,
    ): Invitacion {
        return Invitacion::create([
            'iglesia_id' => $iglesia->id,
            'user_id' => $user->id,
            'email' => $user->email,
            'rol' => $rol,
            'token' => Str::random(64),
            'expires_at' => now()->addDays($diasExpiracion),
        ]);
    }

    public function enviar(Invitacion $invitacion): void
    {
        Mail::to($invitacion->email)
            ->send(new InvitacionMail($invitacion));
    }

    public function crearYEnviar(
        Iglesia $iglesia,
        User $user,
        string $rol = 'admin-iglesia',
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
    }

    public function valida(Invitacion $invitacion): bool
    {
        return $invitacion->accepted_at === null
            && $invitacion->expires_at->isFuture();
    }

    public function buscarPorToken(string $token): ?Invitacion
    {
        return Invitacion::query()
            ->with([
                'user',
                'iglesia',
            ])
            ->where('token', $token)
            ->first();
    }

    public function renovar(
        Invitacion $invitacion,
        int $dias = 2,
    ): Invitacion {
        if ($invitacion->accepted_at) {
            throw new RuntimeException('No se puede renovar una invitación aceptada.');
        }

        $invitacion->update([
            'token' => Str::random(64),
            'accepted_at' => null,
            'expires_at' => now()->addDays($dias),
        ]);

        return $invitacion;
    }

    public function renovarYEnviar(
        Invitacion $invitacion,
        int $dias = 2,
    ): Invitacion {
        $this->renovar($invitacion);
        $this->enviar($invitacion);

        return $invitacion;
    }
}
