<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_usuario(): void
    {
        $usuario = User::factory()->create([
            'name' => 'Juan Perez',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $usuario->id,
            'name' => 'Juan Perez',
        ]);
    }

    public function test_un_usuario_puede_pertenecer_a_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create();

        $usuario = User::factory()
            ->create([
                'iglesia_id' => $iglesia->id,
            ]);

        $this->assertEquals(
            $iglesia->id,
            $usuario->iglesia->id
        );
    }

    public function test_un_usuario_puede_tener_un_servidor_asociado(): void
    {
        $usuario = User::factory()->create();

        $servidor = Servidor::factory()
            ->for($usuario)
            ->create();

        $this->assertEquals(
            $usuario->id,
            $servidor->user->id
        );
    }
}
