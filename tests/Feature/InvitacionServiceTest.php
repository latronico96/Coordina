<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\User;
use App\Services\InvitacionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitacionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_invitacion(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $service = app(InvitacionService::class);

        $invitacion = $service->crear($iglesia, $user);

        $this->assertDatabaseHas('invitacions', [
            'id' => $invitacion->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('action_tokens', [
            'tipo' => 'invitacion',
        ]);

        $this->assertNotNull(
            $invitacion->token()
        );

        $this->assertNotNull(
            $invitacion->token()->expires_at
        );
    }

    public function test_puede_aceptar_una_invitacion(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $service = app(InvitacionService::class);

        $invitacion = $service->crear($iglesia, $user);

        $service->aceptar($invitacion);

        $invitacion->refresh();

        $this->assertNotNull(
            $invitacion->accepted_at
        );
    }

    public function test_puede_buscar_una_invitacion_por_token(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $service = app(InvitacionService::class);

        $invitacion = $service->crear($iglesia, $user);

        $encontrada = $service->buscarPorToken(
            $invitacion->token()->token
        );

        $this->assertNotNull($encontrada);

        $this->assertEquals(
            $invitacion->id,
            $encontrada->id
        );
    }

    public function test_puede_renovar_una_invitacion(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $service = app(InvitacionService::class);

        $invitacion = $service->crear($iglesia, $user);

        $tokenViejo = $invitacion->token()->token;

        $service->renovar($invitacion);

        $invitacion->refresh();

        $this->assertNotEquals(
            $tokenViejo,
            $invitacion->token()->token
        );
    }
}
