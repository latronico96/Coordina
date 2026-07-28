<?php

namespace Tests\Feature;

use App\Models\Asignacion;
use App\Models\Evento;
use App\Models\EventoRol;
use App\Models\Iglesia;
use App\Models\Ministerio;
use App\Models\RolServicio;
use App\Models\Servidor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlujoAsignacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_asignar_un_servidor_a_un_rol_de_evento(): void
    {
        $iglesia = Iglesia::factory()->create();

        $ministerio = Ministerio::factory()
            ->for($iglesia)
            ->create();

        $rolCamara = RolServicio::factory()
            ->for($ministerio)
            ->create([
                'nombre' => 'Cámara',
            ]);

        $servidor = Servidor::factory()
            ->for($iglesia)
            ->create();

        $servidor->rolesServicio()->attach($rolCamara);

        $evento = Evento::factory()
            ->for($iglesia)
            ->create();

        $eventoRol = EventoRol::factory()
            ->for($evento)
            ->for($rolCamara)
            ->create([
                'cantidad' => 1,
            ]);

        $asignacion = Asignacion::factory()
            ->for($evento)
            ->for($eventoRol)
            ->for($servidor)
            ->create();

        $this->assertDatabaseHas('asignacions', [
            'evento_id' => $evento->id,
            'evento_rol_id' => $eventoRol->id,
            'servidor_id' => $servidor->id,
        ]);
    }
}
