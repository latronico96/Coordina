<?php

namespace Tests\Feature;

use App\Enums\RolUsuario;
use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_tiene_rol(): void
    {
        $user = User::factory()->create();

        $user->assignRole(RolUsuario::SUPER_ADMIN);

        $this->assertTrue(
            $user->hasRole(RolUsuario::SUPER_ADMIN)
        );
    }

    public function test_usuario_admin_iglesia_tiene_rol(): void
    {
        $iglesia = Iglesia::factory()->create();

        $user = User::factory()->create([
            'iglesia_id' => $iglesia->id,
        ]);

        $user->assignRole('admin-iglesia');

        $this->assertTrue(
            $user->hasRole('admin-iglesia')
        );

        $this->assertEquals(
            $iglesia->id,
            $user->iglesia->id
        );
    }
}
