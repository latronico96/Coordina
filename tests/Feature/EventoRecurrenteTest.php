<?php

namespace Tests\Feature;

use App\Models\EventoRecurrente;
use App\Models\EventoRecurrenteRol;
use App\Models\Iglesia;
use App\Models\RolServicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoRecurrenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_evento_recurrente(): void
    {
        $evento = EventoRecurrente::factory()->create([
            'nombre' => 'Culto Domingo',
        ]);

        $this->assertDatabaseHas('evento_recurrentes', [
            'id' => $evento->id,
            'nombre' => 'Culto Domingo',
        ]);
    }

    public function test_un_evento_recurrente_pertenece_a_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create();

        $evento = EventoRecurrente::factory()
            ->for($iglesia)
            ->create();

        $this->assertEquals(
            $iglesia->id,
            $evento->iglesia->id
        );
    }

    public function test_un_evento_recurrente_puede_tener_roles_requeridos(): void
    {
        $evento = EventoRecurrente::factory()->create();

        $rolServicio = RolServicio::factory()->create();

        $rolRequerido = EventoRecurrenteRol::factory()
            ->for($evento)
            ->for($rolServicio)
            ->create([
                'cantidad' => 2,
            ]);

        $this->assertTrue(
            $evento->rolesRequeridos->contains($rolRequerido)
        );
    }

    public function test_un_evento_recurrente_se_crea_activo(): void
    {
        $evento = EventoRecurrente::factory()->create();

        $this->assertTrue($evento->activo);
    }
}
