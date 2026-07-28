<?php

namespace Database\Factories;

use App\Models\EventoRecurrente;
use App\Models\Iglesia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventoRecurrente>
 */
class EventoRecurrenteFactory extends Factory
{
    protected $model = EventoRecurrente::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'iglesia_id' => Iglesia::factory(),

            'nombre' => fake()->randomElement([
                'Culto Domingo',
                'Reunión Miércoles',
                'Reunión de Jóvenes',
                'Ensayo de Alabanza',
                'Oración',
                'Estudio Bíblico',
            ]),

            'dia_semana' => fake()->numberBetween(0, 6),

            'hora_inicio' => fake()->randomElement([
                '09:00',
                '10:30',
                '18:00',
                '19:00',
                '20:00',
            ]),

            'activo' => true,
        ];
    }

    /**
     * Evento recurrente inactivo.
     */
    public function inactivo(): static
    {
        return $this->state(fn () => [
            'activo' => false,
        ]);
    }
}
