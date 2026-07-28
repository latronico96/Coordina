<?php

namespace Database\Factories;

use App\Models\Iglesia;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Servidor>
 */
class ServidorFactory extends Factory
{
    protected $model = Servidor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'iglesia_id' => Iglesia::factory(),

            'user_id' => null,

            'nombre' => fake()->firstName(),

            'apellido' => fake()->lastName(),

            'telefono' => fake()->phoneNumber(),

            'email' => fake()->unique()->safeEmail(),

            'activo' => true,
        ];
    }

    /**
     * Servidor inactivo.
     */
    public function inactivo(): static
    {
        return $this->state(fn () => [
            'activo' => false,
        ]);
    }

    public function conUsuario(): static
    {
        return $this->state(fn () => [
            'user_id' => User::factory(),
        ]);
    }
}
