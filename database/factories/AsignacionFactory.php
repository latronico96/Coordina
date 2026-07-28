<?php

namespace Database\Factories;

use App\Models\Asignacion;
use App\Models\Evento;
use App\Models\EventoRol;
use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asignacion>
 */
class AsignacionFactory extends Factory
{
    protected $model = Asignacion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evento_id' => Evento::factory(),

            'evento_rol_id' => EventoRol::factory(),

            'servidor_id' => Servidor::factory(),

            'estado' => 'pendiente',

            'observaciones' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Asignación confirmada.
     */
    public function confirmada(): static
    {
        return $this->state(fn () => [
            'estado' => 'confirmado',
        ]);
    }

    /**
     * Asignación rechazada.
     */
    public function rechazada(): static
    {
        return $this->state(fn () => [
            'estado' => 'rechazado',
        ]);
    }
}
