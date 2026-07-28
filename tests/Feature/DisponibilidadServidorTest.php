<?php

namespace Tests\Feature;

use App\Models\DisponibilidadServidor;
use App\Models\Servidor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisponibilidadServidorTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_disponibilidad(): void
    {
        $disponibilidad = DisponibilidadServidor::factory()->create([
            'motivo' => 'Viaje familiar',
        ]);

        $this->assertDatabaseHas('disponibilidad_servidors', [
            'id' => $disponibilidad->id,
            'motivo' => 'Viaje familiar',
        ]);
    }

    public function test_una_disponibilidad_pertenece_a_un_servidor(): void
    {
        $servidor = Servidor::factory()->create();

        $disponibilidad = DisponibilidadServidor::factory()
            ->for($servidor)
            ->create();

        $this->assertEquals(
            $servidor->id,
            $disponibilidad->servidor->id
        );
    }

    public function test_un_servidor_puede_tener_varias_disponibilidades(): void
    {
        $servidor = Servidor::factory()->create();

        DisponibilidadServidor::factory()
            ->count(3)
            ->for($servidor)
            ->create();

        $this->assertCount(
            3,
            $servidor->disponibilidades
        );
    }

    public function test_guarda_la_fecha_de_disponibilidad(): void
    {
        $disponibilidad = DisponibilidadServidor::factory()->create([
            'fecha' => '2026-08-01',
        ]);

        $this->assertDatabaseHas('disponibilidad_servidors', [
            'id' => $disponibilidad->id,
            'fecha' => '2026-08-01',
        ]);
    }
}
