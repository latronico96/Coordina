<?php

namespace Database\Factories;

use App\Models\Iglesia;
use App\Models\Ministerio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ministerio>
 */
class MinisterioFactory extends Factory
{
    protected $model = Ministerio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'iglesia_id' => Iglesia::factory(),
            'descripcion' => '',
            'nombre' => fake()->randomElement([
                'Alabanza',
                'Audio',
                'Luces',
                'Multimedia',
                'Cámaras',
                'Recepción',
                'Intercesión',
                'Infantiles',
                'Jóvenes',
                'Consolidación',
                'Evangelismo',
                'Producción',
            ]),

            'activo' => true,
        ];
    }

    /**
     * Ministerio inactivo.
     */
    public function inactivo(): static
    {
        return $this->state(fn () => [
            'activo' => false,
        ]);
    }
}
