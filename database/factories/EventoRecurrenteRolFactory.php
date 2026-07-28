<?php

namespace Database\Factories;

use App\Models\EventoRecurrente;
use App\Models\EventoRecurrenteRol;
use App\Models\RolServicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventoRecurrenteRol>
 */
class EventoRecurrenteRolFactory extends Factory
{
    protected $model = EventoRecurrenteRol::class;

    public function definition(): array
    {
        return [
            'evento_recurrente_id' => EventoRecurrente::factory(),

            'rol_servicio_id' => RolServicio::factory(),

            'cantidad' => fake()->numberBetween(1, 3),
        ];
    }
}
