<?php

namespace App\Services;

use App\Models\Iglesia;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IglesiaService
{
    public function __construct(
        private InvitacionService $invitacionService
    ) {}

    public function crearConAdministrador(array $datos): Iglesia
    {
        return DB::transaction(function () use ($datos) {

            $iglesia = Iglesia::create([
                'nombre' => $datos['nombre'],
                'direccion' => $datos['direccion'] ?? null,
                'activo' => true,
            ]);

            $usuario = User::create([
                'name' => $datos['admin_nombre'],
                'email' => $datos['admin_email'],
                'password' => Hash::make(Str::random(32)),
                'iglesia_id' => $iglesia->id,
            ]);

            $usuario->assignRole('admin-iglesia');

            $this->invitacionService->crearYEnviar($iglesia, $usuario);
            Notification::make()
                ->title('Iglesia creada')
                ->body('Se envió una invitación al administrador.')
                ->success()
                ->send();

            return $iglesia;
        });
    }
}
