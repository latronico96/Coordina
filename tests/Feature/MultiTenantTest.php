<?php

namespace Tests\Feature;

use App\Filament\Resources\Eventos\EventoResource;
use App\Models\Evento;
use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenantTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_no_puede_ver_eventos_de_otra_iglesia(): void
    {
        $iglesiaA = Iglesia::factory()->create([
            'nombre' => 'Iglesia A',
        ]);
        $iglesiaB = Iglesia::factory()->create([
            'nombre' => 'Iglesia B',
        ]);
        $usuario = User::factory()
            ->for($iglesiaA)
            ->create();
        Evento::factory()
            ->for($iglesiaA)
            ->create([
                'nombre' => 'Evento permitido',
            ]);
        Evento::factory()
            ->for($iglesiaB)
            ->create([
                'nombre' => 'Evento prohibido',
            ]);
        $this->actingAs($usuario);
        $eventos = Evento::query()->get();
        $this->assertCount(2, $eventos);
    }

    public function test_admin_solo_ve_eventos_de_su_iglesia(): void
    {
        $iglesiaA = Iglesia::factory()->create();
        $iglesiaB = Iglesia::factory()->create();
        $usuario = User::factory()
            ->for($iglesiaA)
            ->create();
        $usuario->assignRole('admin-iglesia');
        Evento::factory()
            ->for($iglesiaA)
            ->create();
        Evento::factory()
            ->for($iglesiaB)
            ->create();
        $this->actingAs($usuario);
        $query = EventoResource::getEloquentQuery();
        $this->assertTrue(
            $query->where('iglesia_id', $iglesiaA->id)->exists()
        );
        $this->assertFalse(
            $query->where('iglesia_id', $iglesiaB->id)->exists()
        );
    }
}
