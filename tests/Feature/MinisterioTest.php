<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\Ministerio;
use App\Models\RolServicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MinisterioTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_ministerio(): void
    {
        $ministerio = Ministerio::factory()->create([
            'nombre' => 'Multimedia',
        ]);

        $this->assertDatabaseHas('ministerios', [
            'id' => $ministerio->id,
            'nombre' => 'Multimedia',
        ]);
    }

    public function test_un_ministerio_se_crea_activo_por_defecto(): void
    {
        $ministerio = Ministerio::factory()->create();

        $this->assertTrue($ministerio->activo);
    }

    public function test_un_ministerio_pertenece_a_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create();

        $ministerio = Ministerio::factory()
            ->for($iglesia)
            ->create();

        $this->assertEquals(
            $iglesia->id,
            $ministerio->iglesia->id
        );
    }

    public function test_un_ministerio_puede_tener_roles_de_servicio(): void
    {
        $ministerio = Ministerio::factory()->create();

        $rol = RolServicio::factory()
            ->for($ministerio)
            ->create([
                'nombre' => 'Cámara',
            ]);

        $this->assertTrue(
            $ministerio->rolesServicio->contains($rol)
        );
    }
}
