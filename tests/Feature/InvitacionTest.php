<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\Invitacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_una_invitacion_pertenece_a_una_iglesia(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $invitacion = Invitacion::factory()
            ->for($iglesia)
            ->for($user)
            ->create();

        $this->assertEquals(
            $iglesia->id,
            $invitacion->iglesia->id
        );
    }

    public function test_una_invitacion_puede_estar_aceptada(): void
    {
        $iglesia = Iglesia::factory()->create();

        $invitacion = Invitacion::factory()
            ->for($iglesia)
            ->aceptada()
            ->create();

        $this->assertNotNull(
            $invitacion->accepted_at
        );
    }

    public function test_una_invitacion_puede_vencer(): void
    {
        $invitacion = Invitacion::factory()
            ->vencida()
            ->create();

        $this->assertTrue(
            $invitacion->expires_at->isPast()
        );
    }

    public function test_una_invitacion_puede_asociarse_a_un_usuario_al_aceptar(): void
    {
        $user = User::factory()->create();

        $invitacion = Invitacion::factory()->create([
            'user_id' => $user->id,
            'accepted_at' => now(),
        ]);

        $this->assertEquals(
            $user->id,
            $invitacion->user->id
        );
    }

    public function test_una_invitacion_tiene_estado_pendiente(): void
    {
        $invitacion = Invitacion::factory()->create();

        $this->assertEquals(
            'pendiente',
            $invitacion->estado()
        );
    }
}
