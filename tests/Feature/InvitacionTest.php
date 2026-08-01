<?php

namespace Tests\Feature;

use App\Models\ActionToken;
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

        $this->assertTrue(
            $invitacion->iglesia->is($iglesia)
        );
    }

    public function test_una_invitacion_pertenece_a_un_usuario(): void
    {
        $user = User::factory()->create();

        $invitacion = Invitacion::factory()
            ->for($user)
            ->create();

        $this->assertTrue(
            $invitacion->user->is($user)
        );
    }

    public function test_una_invitacion_puede_obtener_su_action_token(): void
    {
        $user = User::factory()->create();

        $invitacion = Invitacion::factory()
            ->for($user)
            ->create();

        $token = ActionToken::factory()
            ->invitacion()
            ->create([
                'user_id' => $user->id,
                'payload' => [
                    'invitacion_id' => $invitacion->id,
                ],
            ]);

        $this->assertEquals(
            $token->id,
            $invitacion->token()->id
        );
    }

    public function test_una_invitacion_puede_obtener_su_url(): void
    {
        $user = User::factory()->create();

        $invitacion = Invitacion::factory()
            ->for($user)
            ->create();

        $token = ActionToken::factory()
            ->invitacion()
            ->create([
                'user_id' => $user->id,
                'payload' => [
                    'invitacion_id' => $invitacion->id,
                ],
            ]);

        $this->assertEquals(
            route('invitacion.aceptar', $token->token),
            $invitacion->url()
        );
    }
}
