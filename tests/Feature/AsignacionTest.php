<?php

namespace Tests\Feature;

use App\Models\Asignacion;
use App\Models\Evento;
use App\Models\EventoRol;
use App\Models\RolServicio;
use App\Models\Servidor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AsignacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_asignacion(): void
    {
        $asignacion = Asignacion::factory()->create([
            'estado' => 'pendiente',
        ]);

        $this->assertDatabaseHas('asignacions', [
            'id' => $asignacion->id,
            'estado' => 'pendiente',
        ]);
    }

    public function test_una_asignacion_pertenece_a_un_evento(): void
    {
        $evento = Evento::factory()->create();

        $asignacion = Asignacion::factory()
            ->for($evento)
            ->create();

        $this->assertEquals(
            $evento->id,
            $asignacion->evento->id
        );
    }

    public function test_una_asignacion_pertenece_a_un_rol_del_evento(): void
    {
        $evento = Evento::factory()->create();

        $rolServicio = RolServicio::factory()->create();

        $eventoRol = EventoRol::factory()
            ->for($evento)
            ->for($rolServicio)
            ->create();

        $asignacion = Asignacion::factory()
            ->for($evento)
            ->for($eventoRol)
            ->create();

        $this->assertEquals(
            $eventoRol->id,
            $asignacion->eventoRol->id
        );
    }

    public function test_una_asignacion_puede_tener_un_servidor(): void
    {
        $servidor = Servidor::factory()->create();

        $asignacion = Asignacion::factory()
            ->for($servidor)
            ->create();

        $this->assertEquals(
            $servidor->id,
            $asignacion->servidor->id
        );
    }

    public function test_estado_de_asignacion_por_defecto_es_pendiente(): void
    {
        $asignacion = Asignacion::factory()->create();

        $this->assertEquals(
            'pendiente',
            $asignacion->estado
        );
    }
}
