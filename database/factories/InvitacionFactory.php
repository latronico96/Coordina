<?php

namespace Database\Factories;

use App\Enums\RolUsuario;
use App\Models\Iglesia;
use App\Models\Invitacion;
use App\Models\RolServicio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invitacion>
 */
class InvitacionFactory extends Factory
{
    public function definition(): array
    {
        return [

            'iglesia_id' => Iglesia::factory(),

            'user_id' => User::factory(),

            'email' => fake()->safeEmail(),

            'rol' => RolUsuario::ADMIN_IGLESIA->value

        ];
    }
}
