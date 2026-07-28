<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\EventoRol;
use App\Models\RolServicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventoRol>
 */
class EventoRolFactory extends Factory
{
    protected $model = EventoRol::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evento_id' => Evento::factory(),

            'rol_servicio_id' => RolServicio::factory(),

            'cantidad' => fake()->numberBetween(1, 3),
        ];
    }
}
