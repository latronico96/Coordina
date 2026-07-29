<?php

namespace Database\Factories;

use App\Models\Iglesia;
use App\Models\Invitacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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

            'rol' => 'admin-iglesia',

            'token' => Str::random(64),

            'expires_at' => now()->addDays(2),

        ];
    }

    public function aceptada()
    {
        return $this->state([
            'accepted_at' => now(),
        ]);
    }

    public function vencida()
    {
        return $this->state([
            'expires_at' => now()->subDay(),
        ]);
    }
}
