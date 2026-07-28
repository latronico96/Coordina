<?php

namespace Database\Factories;

use App\Models\DisponibilidadServidor;
use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisponibilidadServidor>
 */
class DisponibilidadServidorFactory extends Factory
{
    protected $model = DisponibilidadServidor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'servidor_id' => Servidor::factory(),

            'fecha' => fake()->date(),

            'motivo' => fake()->randomElement([
                'Vacaciones',
                'Trabajo',
                'Estudio',
                'Compromiso familiar',
                'No disponible',
                'Otro',
            ]),
        ];
    }
}
