<?php

namespace Database\Factories;

use App\Models\Ministerio;
use App\Models\RolServicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RolServicio>
 */
class RolServicioFactory extends Factory
{
    protected $model = RolServicio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ministerio_id' => Ministerio::factory(),

            'nombre' => fake()->randomElement([
                'Cámara',
                'OBS',
                'Pantalla',
                'Monitor',
                'Audio',
                'Luces',
                'Streaming',
                'Redes',
                'Recepción',
                'Ujier',
            ]),

            'minutos_preparacion' => fake()->randomElement([
                15,
                20,
                30,
                45,
                60,
                90,
            ]),

            'activo' => true,
        ];
    }

    /**
     * Rol inactivo.
     */
    public function inactivo(): static
    {
        return $this->state(fn () => [
            'activo' => false,
        ]);
    }
}
