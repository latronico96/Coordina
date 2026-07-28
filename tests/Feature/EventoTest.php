<?php

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\EventoRecurrente;
use App\Models\EventoRol;
use App\Models\Iglesia;
use App\Models\RolServicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_evento(): void
    {
        $evento = Evento::factory()->create([
            'nombre' => 'Culto Domingo',
        ]);

        $this->assertDatabaseHas('eventos', [
            'id' => $evento->id,
            'nombre' => 'Culto Domingo',
        ]);
    }

    public function test_un_evento_pertenece_a_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create();

        $evento = Evento::factory()
            ->for($iglesia)
            ->create();

        $this->assertEquals(
            $iglesia->id,
            $evento->iglesia->id
        );
    }

    public function test_un_evento_puede_generarse_desde_un_recurrente(): void
    {
        $recurrente = EventoRecurrente::factory()->create();

        $evento = Evento::factory()
            ->for($recurrente, 'eventoRecurrente')
            ->create();

        $this->assertEquals(
            $recurrente->id,
            $evento->eventoRecurrente->id
        );
    }

    public function test_un_evento_puede_tener_roles_requeridos(): void
    {
        $evento = Evento::factory()->create();

        $rolServicio = RolServicio::factory()->create();

        $eventoRol = EventoRol::factory()
            ->for($evento)
            ->for($rolServicio)
            ->create([
                'cantidad' => 2,
            ]);

        $this->assertTrue(
            $evento->rolesRequeridos->contains($eventoRol)
        );
    }
}
