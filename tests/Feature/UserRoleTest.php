<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Iglesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_tiene_rol(): void
    {
        $user = User::factory()->create();

        $user->assignRole('super-admin');

        $this->assertTrue(
            $user->hasRole('super-admin')
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
