<?php

namespace Tests\Feature;

use App\Models\Asignacion;
use App\Models\Evento;
use App\Models\EventoRol;
use App\Models\RolServicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoRolTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_rol_requerido_para_un_evento(): void
    {
        $evento = Evento::factory()->create();

        $rolServicio = RolServicio::factory()->create();

        $eventoRol = EventoRol::factory()
            ->for($evento)
            ->for($rolServicio)
            ->create([
                'cantidad' => 2,
            ]);

        $this->assertDatabaseHas('evento_rols', [
            'id' => $eventoRol->id,
            'evento_id' => $evento->id,
            'rol_servicio_id' => $rolServicio->id,
            'cantidad' => 2,
        ]);
    }

    public function test_un_evento_rol_pertenece_a_un_evento(): void
    {
        $evento = Evento::factory()->create();

        $eventoRol = EventoRol::factory()
            ->for($evento)
            ->create();

        $this->assertEquals(
            $evento->id,
            $eventoRol->evento->id
        );
    }

    public function test_un_evento_rol_pertenece_a_un_rol_servicio(): void
    {
        $rolServicio = RolServicio::factory()->create();

        $eventoRol = EventoRol::factory()
            ->for($rolServicio)
            ->create();

        $this->assertEquals(
            $rolServicio->id,
            $eventoRol->rolServicio->id
        );
    }

    public function test_un_evento_rol_puede_tener_varias_asignaciones(): void
    {
        $eventoRol = EventoRol::factory()->create();

        $asignaciones = Asignacion::factory()
            ->count(2)
            ->for($eventoRol)
            ->create();

        $this->assertCount(
            2,
            $eventoRol->asignaciones
        );
    }
}
