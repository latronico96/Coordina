<?php

namespace Tests\Feature;

use App\Models\Ministerio;
use App\Models\RolServicio;
use App\Models\Servidor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolServicioTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_rol_de_servicio(): void
    {
        $rol = RolServicio::factory()->create([
            'nombre' => 'Cámara',
        ]);

        $this->assertDatabaseHas('rol_servicios', [
            'id' => $rol->id,
            'nombre' => 'Cámara',
        ]);
    }

    public function test_un_rol_de_servicio_pertenece_a_un_ministerio(): void
    {
        $ministerio = Ministerio::factory()->create();

        $rol = RolServicio::factory()
            ->for($ministerio)
            ->create();

        $this->assertEquals(
            $ministerio->id,
            $rol->ministerio->id
        );
    }

    public function test_un_rol_de_servicio_puede_tener_servidores(): void
    {
        $rol = RolServicio::factory()->create();

        $servidor = Servidor::factory()->create();

        $servidor->rolesServicio()->attach($rol);

        $this->assertTrue(
            $rol->servidores->contains($servidor)
        );
    }

    public function test_un_rol_se_crea_activo_por_defecto(): void
    {
        $rol = RolServicio::factory()->create();

        $this->assertTrue($rol->activo);
    }
}
