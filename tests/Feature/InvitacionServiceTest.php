<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\Invitacion;
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

        $this->assertNotNull(
            $invitacion->token
        );

        $this->assertNotNull(
            $invitacion->expires_at
        );
    }

    public function test_una_invitacion_nueva_es_valida(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $service = app(InvitacionService::class);

        $invitacion = $service->crear($iglesia, $user);

        $this->assertTrue(
            $service->valida($invitacion)
        );
    }

    public function test_una_invitacion_aceptada_ya_no_es_valida(): void
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

        $this->assertFalse(
            $service->valida($invitacion)
        );
    }

    public function test_una_invitacion_vencida_no_es_valida(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $invitacion = Invitacion::factory()
            ->for($iglesia)
            ->for($user)
            ->create([
                'user_id' => $user->id,
                'expires_at' => now()->subDay(),
            ]);

        $service = app(InvitacionService::class);

        $this->assertFalse(
            $service->valida($invitacion)
        );
    }
}
