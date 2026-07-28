<?php

namespace Tests\Feature;

use App\Models\EventoRecurrente;
use App\Models\EventoRecurrenteRol;
use App\Models\RolServicio;
use App\Services\EventoService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_evento_desde_evento_recurrente(): void
    {
        $eventoRecurrente = EventoRecurrente::factory()->create();

        $camara = RolServicio::factory()->create();
        $audio = RolServicio::factory()->create();

        EventoRecurrenteRol::factory()->create([
            'evento_recurrente_id' => $eventoRecurrente->id,
            'rol_servicio_id' => $camara->id,
            'cantidad' => 2,
        ]);

        EventoRecurrenteRol::factory()->create([
            'evento_recurrente_id' => $eventoRecurrente->id,
            'rol_servicio_id' => $audio->id,
            'cantidad' => 1,
        ]);

        $service = app(EventoService::class);

        $fecha = Carbon::parse('2026-08-15');

        $evento = $service->crearDesdeRecurrente(
            $eventoRecurrente,
            $fecha
        );

        $this->assertDatabaseHas('eventos', [
            'id' => $evento->id,
            'evento_recurrente_id' => $eventoRecurrente->id,
            'iglesia_id' => $eventoRecurrente->iglesia_id,
            'nombre' => $eventoRecurrente->nombre,
            'hora_inicio' => $eventoRecurrente->hora_inicio,
        ]);
        $evento->refresh();

        $this->assertEquals(
            $fecha->toDateString(),
            $evento->fecha->toDateString()
        );

        $evento->refresh();

        $this->assertCount(2, $evento->rolesRequeridos);

        $this->assertDatabaseHas('evento_rols', [
            'evento_id' => $evento->id,
            'rol_servicio_id' => $camara->id,
            'cantidad' => 2,
        ]);

        $this->assertDatabaseHas('evento_rols', [
            'evento_id' => $evento->id,
            'rol_servicio_id' => $audio->id,
            'cantidad' => 1,
        ]);
    }
}
