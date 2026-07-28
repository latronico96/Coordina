<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IglesiaTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create([
            'nombre' => 'Iglesia Demo',
        ]);

        $this->assertDatabaseHas('iglesias', [
            'id' => $iglesia->id,
            'nombre' => 'Iglesia Demo',
        ]);
    }

    public function test_una_iglesia_se_crea_activa_por_defecto(): void
    {
        $iglesia = Iglesia::factory()->create();

        $this->assertTrue($iglesia->activo);
    }

    public function test_una_iglesia_puede_tener_servidores(): void
    {
        $iglesia = Iglesia::factory()->create();

        $servidor = Servidor::factory()
            ->for($iglesia)
            ->create();

        $this->assertTrue(
            $iglesia->servidores->contains($servidor)
        );
    }

    public function test_una_iglesia_puede_tener_un_usuario_admin(): void
    {
        $iglesia = Iglesia::factory()->create();

        $usuario = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $this->assertEquals(
            $iglesia->id,
            $usuario->iglesia->id
        );
    }
}
