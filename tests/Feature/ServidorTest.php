<?php

namespace Tests\Feature;

use App\Models\DisponibilidadServidor;
use App\Models\Iglesia;
use App\Models\RolServicio;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServidorTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_servidor(): void
    {
        $servidor = Servidor::factory()->create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
        ]);

        $this->assertDatabaseHas('servidors', [
            'id' => $servidor->id,
            'nombre' => 'Juan',
            'apellido' => 'Perez',
        ]);
    }

    public function test_un_servidor_pertenece_a_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create();

        $servidor = Servidor::factory()
            ->for($iglesia)
            ->create();

        $this->assertEquals(
            $iglesia->id,
            $servidor->iglesia->id
        );
    }

    public function test_un_servidor_puede_tener_usuario(): void
    {
        $usuario = User::factory()->create();

        $servidor = Servidor::factory()->create([
            'user_id' => $usuario->id,
        ]);

        $this->assertEquals(
            $usuario->id,
            $servidor->user->id
        );
    }

    public function test_un_servidor_puede_tener_roles_de_servicio(): void
    {
        $servidor = Servidor::factory()->create();

        $rol = RolServicio::factory()->create();

        $servidor->rolesServicio()->attach($rol);

        $this->assertTrue(
            $servidor->rolesServicio->contains($rol)
        );
    }

    public function test_un_servidor_puede_tener_disponibilidades(): void
    {
        $servidor = Servidor::factory()->create();

        $disponibilidad = DisponibilidadServidor::factory()
            ->for($servidor)
            ->create();

        $this->assertTrue(
            $servidor->disponibilidades->contains($disponibilidad)
        );
    }
}
