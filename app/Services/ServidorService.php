<?php

namespace App\Services;

use App\Models\Servidor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ServidorService
{
    public function __construct(
        private readonly ActionTokenService $actionTokenService,
        private readonly EventoNotificacionService $eventoNotificacionService,
        private readonly InvitacionService $invitacionService,
    ) {}

    public function crearUsuarioEInvitar(Servidor $servidor): void
    {
        if ($servidor->user) {
            return;
        }

        if (User::where('email', $servidor->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Este email ya está registrado. Utilice otro email.',
            ]);
        }

        $user = User::create([
            'name' => trim($servidor->nombre.' '.$servidor->apellido),
            'email' => $servidor->email,
            'password' => Hash::make(Str::random(32)),
            'iglesia_id' => $servidor->iglesia_id,
        ]);

        $servidor->update([
            'user_id' => $user->id,
        ]);

        $this->invitacionService
            ->crearYEnviar(
                iglesia: $servidor->iglesia,
                user: $user,
            );
    }

    public function reenviarInvitacion(Servidor $servidor): void
    {
        if (! $servidor->user) {
            return;
        }

        $invitacion = $servidor->user
            ->invitaciones()
            ->latest()
            ->first();

        if (! $invitacion) {
            return;
        }

        $this->invitacionService->renovarYEnviar($invitacion);
    }
}
