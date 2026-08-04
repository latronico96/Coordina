<?php

namespace App\Services;

use App\Enums\RolUsuario;
use App\Models\Iglesia;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class IglesiaService
{
    public function __construct(
        private InvitacionService $invitacionService
    ) {}

    public function crearConAdministrador(array $datos): Iglesia
    {
        if (User::where('email', $datos['admin_email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Este email ya está registrado. Utilice otro email.',
            ]);
        }
        return DB::transaction(function () use ($datos) {

            $iglesia = Iglesia::create([
                'nombre' => $datos['nombre'],
                'direccion' => $datos['direccion'] ?? null,
                'activo' => true,
                'logo_url' => $datos['logo_url'] ?? null,
                'color_primario' => $datos['color_primario'] ?? null,
                'color_secundario' => $datos['color_secundario'] ?? null,
                'google_calendar_habilitado' => $datos['google_calendar_habilitado'] ?? false,
                'google_calendar_id' => $datos['google_calendar_id'] ?? null,
                'email_contacto' => $datos['email_contacto'] ?? null,
                'telefono_contacto' => $datos['telefono_contacto'] ?? null,
            ]);

            $usuario = User::create([
                'name' => $datos['admin_nombre'],
                'email' => $datos['admin_email'],
                'password' => Hash::make(Str::random(32)),
                'iglesia_id' => $iglesia->id,
            ]);

            $usuario->assignRole(RolUsuario::ADMIN_IGLESIA->value);

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
