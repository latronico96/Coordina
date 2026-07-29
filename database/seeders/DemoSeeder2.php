<?php

namespace Database\Seeders;

use App\Models\Asignacion;
use App\Models\Evento;
use App\Models\EventoRecurrente;
use App\Models\EventoRecurrenteRol;
use App\Models\EventoRol;
use App\Models\Iglesia;
use App\Models\Invitacion;
use App\Models\Ministerio;
use App\Models\RolServicio;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder2 extends Seeder
{
    public function run(): void
    {
        $this->crearIglesiaDemo('Iglesia Central');
        $this->crearIglesiaDemo('Iglesia Norte');
    }

    private function crearIglesiaDemo(string $nombre): void
    {
        $iglesia = Iglesia::factory()->create([
            'nombre' => $nombre,
        ]);

        $ministerio = Ministerio::factory()
            ->for($iglesia)
            ->create([
                'nombre' => "Multimedia {$nombre}",
            ]);

        $roles = RolServicio::factory()
            ->count(6)
            ->for($ministerio)
            ->create();

        $servidores = Servidor::factory()
            ->count(15)
            ->for($iglesia)
            ->create();

        foreach ($servidores as $index => $servidor) {
            $servidor->update([
                'nombre' => "Servidor {$nombre} {$index}",
            ]);

            $servidor->rolesServicio()->attach(
                $roles->random(rand(1, 3))->pluck('id')
            );
        }

        $eventoRecurrente = EventoRecurrente::factory()
            ->for($iglesia)
            ->create([
                'nombre' => "Domingo 19hs {$nombre}",
            ]);

        foreach ($roles as $rol) {
            EventoRecurrenteRol::factory()
                ->for($eventoRecurrente)
                ->for($rol)
                ->create();
        }

        $eventos = Evento::factory()
            ->count(4)
            ->for($iglesia)
            ->for($eventoRecurrente)
            ->create();

        foreach ($eventos as $evento) {

            foreach ($roles as $rolServicio) {

                $eventoRol = EventoRol::factory()
                    ->for($evento)
                    ->for($rolServicio)
                    ->create([
                        'cantidad' => 1,
                    ]);

                $candidatos = $servidores
                    ->filter(
                        fn ($s) => $s->rolesServicio
                            ->contains($rolServicio->id)
                    );

                if ($candidatos->isNotEmpty()) {

                    Asignacion::factory()
                        ->for($evento)
                        ->for($eventoRol)
                        ->for($candidatos->random())
                        ->create();
                }
            }
        }

        $admin = User::factory()
            ->for($iglesia)
            ->create([
                'name' => "Admin {$nombre}",
                'email' => "admin{$iglesia->id}@coordina.test",
            ]);

        $admin->assignRole('admin-iglesia');

        User::factory(2)
            ->for($iglesia)
            ->create()
            ->each(function ($u, $index) use ($nombre) {

                $u->update([
                    'name' => "Lider {$nombre} {$index}",
                ]);

                $u->assignRole('lider-ministerio');
            });

        Invitacion::factory()
            ->count(5)
            ->for($iglesia)
            ->create();

        Invitacion::factory()
            ->aceptada()
            ->for($iglesia)
            ->count(2)
            ->create();

        Invitacion::factory()
            ->vencida()
            ->for($iglesia)
            ->count(2)
            ->create();
    }
}
