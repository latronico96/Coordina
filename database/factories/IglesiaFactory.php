<?php

namespace Database\Factories;

use App\Models\Iglesia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Iglesia>
 */
class IglesiaFactory extends Factory
{
    protected $model = Iglesia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement([
                'Iglesia Centro',
                'Iglesia Norte',
                'Iglesia Sur',
                'Iglesia Betel',
                'Iglesia Esperanza',
                'Iglesia Vida Nueva',
                'Iglesia El Camino',
                'Iglesia La Roca',
            ]),

            'direccion' => fake()->streetAddress(),

            'activo' => true,
        ];
    }

    /**
     * Iglesia inactiva.
     */
    public function inactiva(): static
    {
        return $this->state(fn () => [
            'activo' => false,
        ]);
    }
}
