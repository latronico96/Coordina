<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\EventoRecurrente;
use App\Models\Iglesia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Evento>
 */
class EventoFactory extends Factory
{
    protected $model = Evento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'iglesia_id' => Iglesia::factory(),

            'evento_recurrente_id' => EventoRecurrente::factory(),

            'nombre' => fake()->randomElement([
                'Culto Domingo',
                'Reunión Miércoles',
                'Reunión Especial',
                'Evento Especial',
                'Ensayo',
            ]),

            'fecha' => fake()->date(),

            'hora_inicio' => fake()->randomElement([
                '09:00',
                '10:30',
                '18:00',
                '19:00',
                '20:00',
            ]),

            'estado' => 'pendiente',
        ];
    }

    /**
     * Evento confirmado.
     */
    public function confirmado(): static
    {
        return $this->state(fn () => [
            'estado' => 'confirmado',
        ]);
    }

    /**
     * Evento cancelado.
     */
    public function cancelado(): static
    {
        return $this->state(fn () => [
            'estado' => 'cancelado',
        ]);
    }
}
