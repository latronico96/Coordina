<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_usuario_puede_iniciar_sesion(): void
    {
        $user = User::factory()->create([
            'email' => 'usuario@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'usuario@test.com',
            'password' => 'password123',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user',
            ]);
    }

    public function test_un_usuario_no_puede_iniciar_sesion_con_password_incorrecta(): void
    {
        $user = User::factory()->create([
            'email' => 'usuario@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'usuario@test.com',
            'password' => 'incorrecta',
        ]);

        $response->assertStatus(401);
    }

    public function test_usuario_autenticado_puede_obtener_su_perfil(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this
            ->withToken($token)
            ->getJson('/api/user');

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    }

    public function test_usuario_sin_token_no_puede_obtener_perfil(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_usuario_puede_cerrar_sesion(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this
            ->withToken($token)
            ->postJson('/api/logout');

        $response->assertStatus(200);
    }
}
