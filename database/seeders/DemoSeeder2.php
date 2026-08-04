<?php

namespace Database\Seeders;

use App\Enums\RolUsuario;
use App\Models\ActionToken;
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
use Illuminate\Support\Carbon;

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
            'logo_url' => 'https://yt3.googleusercontent.com/WJNcJ2bT92YRuYJNbfKG84L8biXjimj0a7hqYalSAAqTGFbJX9cQsLi5VBMyikB87CeDhjU-NA=s160-c-k-c0x00ffffff-no-rj',
            'google_calendar_habilitado' => 1,
            'google_calendar_id' => '23c8b4f2529c00537c4cd03cda7d119e67278b9d66844c3aaf5ef3d8de100527@group.calendar.google.com',
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
            ->state([
                'fecha' => Carbon::tomorrow()->toDateString(),
            ])
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
                'password' => '12345678',
            ]);

        $admin->assignRole(RolUsuario::ADMIN_IGLESIA->value);

        User::factory(2)
            ->for($iglesia)
            ->create()
            ->each(function ($u, $index) use ($nombre) {
                $u->update([
                    'name' => "Lider {$nombre} {$index}",
                ]);

                $u->assignRole('lider-ministerio');
            });

        // Pendientes
        Invitacion::factory()
            ->count(5)
            ->for($iglesia)
            ->create()
            ->each(function (Invitacion $invitacion) {

                ActionToken::factory()
                    ->invitacion()
                    ->create([
                        'user_id' => $invitacion->user_id,
                        'payload' => [
                            'invitacion_id' => $invitacion->id,
                        ],
                    ]);
            });

        // Aceptadas
        Invitacion::factory()
            ->count(2)
            ->for($iglesia)
            ->create()
            ->each(function (Invitacion $invitacion) {

                ActionToken::factory()
                    ->invitacion()
                    ->usado()
                    ->create([
                        'user_id' => $invitacion->user_id,
                        'payload' => [
                            'invitacion_id' => $invitacion->id,
                        ],
                    ]);
            });

        // Vencidas
        Invitacion::factory()
            ->count(2)
            ->for($iglesia)
            ->create()
            ->each(function (Invitacion $invitacion) {

                ActionToken::factory()
                    ->invitacion()
                    ->vencido()
                    ->create([
                        'user_id' => $invitacion->user_id,
                        'payload' => [
                            'invitacion_id' => $invitacion->id,
                        ],
                    ]);
            });
    }
}
