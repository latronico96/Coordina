<?php

namespace Tests\Feature;

use App\Enums\RolUsuario;
use App\Models\Invitacion;
use App\Models\User;
use App\Services\IglesiaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IglesiaServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_una_iglesia_con_administrador(): void
    {
        $service = app(IglesiaService::class);

        $iglesia = $service->crearConAdministrador([
            'nombre' => 'Iglesia Demo',
            'direccion' => 'Calle Principal 123',

            'admin_nombre' => 'Juan Perez',
            'admin_email' => 'juan@iglesia.com',
        ]);

        $this->assertDatabaseHas('iglesias', [
            'id' => $iglesia->id,
            'nombre' => 'Iglesia Demo',
        ]);

        $usuario = User::where(
            'email',
            'juan@iglesia.com'
        )->first();

        $this->assertNotNull($usuario);

        $this->assertEquals(
            $iglesia->id,
            $usuario->iglesia_id
        );

        $this->assertTrue(
            $usuario->hasAnyRole(RolUsuario::administracionIglesia())
        );

        $this->assertDatabaseHas('invitacions', [
            'user_id' => $usuario->id,
        ]);
    }

    public function test_crea_usuario_con_invitacion_pendiente(): void
    {
        $service = app(IglesiaService::class);

        $iglesia = $service->crearConAdministrador([
            'nombre' => 'Nueva Vida',

            'admin_nombre' => 'Maria Gomez',
            'admin_email' => 'maria@iglesia.com',
        ]);

        $usuario = $iglesia
            ->usuarios()
            ->first();

        $this->assertNotNull($usuario);

        $invitacion = Invitacion::where(
            'user_id',
            $usuario->id
        )->first();

        $this->assertNotNull($invitacion);

        $this->assertNull(
            $invitacion->accepted_at
        );

        $this->assertTrue(
            $invitacion->token()->expires_at->isFuture()
        );
    }
}
