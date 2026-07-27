<?php

namespace Database\Seeders;

use App\Models\EventoRecurrente;
use App\Models\EventoRecurrenteRol;
use App\Models\Iglesia;
use App\Models\Ministerio;
use App\Models\RolServicio;
use App\Models\Servidor;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $iglesia = Iglesia::create([
            'nombre' => 'Iglesia Central',
            'direccion' => 'Calle 123',
            'activo' => true,
        ]);

        $multimedia = Ministerio::create([
            'iglesia_id' => $iglesia->id,
            'nombre' => 'Multimedia',
            'descripcion' => 'Ministerio Multimedia',
            'activo' => true,
        ]);

        $camara = RolServicio::create([
            'ministerio_id' => $multimedia->id,
            'nombre' => 'Cámara',
            'minutos_preparacion' => 30,
            'activo' => true,
        ]);

        $audio = RolServicio::create([
            'ministerio_id' => $multimedia->id,
            'nombre' => 'Audio',
            'minutos_preparacion' => 45,
            'activo' => true,
        ]);

        $obs = RolServicio::create([
            'ministerio_id' => $multimedia->id,
            'nombre' => 'OBS',
            'minutos_preparacion' => 20,
            'activo' => true,
        ]);

        $pantalla = RolServicio::create([
            'ministerio_id' => $multimedia->id,
            'nombre' => 'Pantalla',
            'minutos_preparacion' => 20,
            'activo' => true,
        ]);

        $evento = EventoRecurrente::create([
            'iglesia_id' => $iglesia->id,
            'nombre' => 'Domingo 19:00',
            'dia_semana' => 1,
            'hora_inicio' => '19:00',
            'activo' => true,
        ]);

        EventoRecurrenteRol::create([
            'evento_recurrente_id' => $evento->id,
            'rol_servicio_id' => $camara->id,
            'cantidad' => 2,
        ]);

        EventoRecurrenteRol::create([
            'evento_recurrente_id' => $evento->id,
            'rol_servicio_id' => $audio->id,
            'cantidad' => 1,
        ]);

        EventoRecurrenteRol::create([
            'evento_recurrente_id' => $evento->id,
            'rol_servicio_id' => $obs->id,
            'cantidad' => 1,
        ]);

        EventoRecurrenteRol::create([
            'evento_recurrente_id' => $evento->id,
            'rol_servicio_id' => $pantalla->id,
            'cantidad' => 1,
        ]);

        $juan = Servidor::create([
            'iglesia_id' => $iglesia->id,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'telefono' => '221111111',
            'email' => 'juan@test.com',
            'activo' => true,
        ]);

        $pedro = Servidor::create([
            'iglesia_id' => $iglesia->id,
            'nombre' => 'Pedro',
            'apellido' => 'Gómez',
            'telefono' => '222222222',
            'email' => 'pedro@test.com',
            'activo' => true,
        ]);

        $juan->rolesServicio()->attach([$camara->id, $obs->id]);
        $pedro->rolesServicio()->attach([$audio->id, $pantalla->id]);
    }
}
