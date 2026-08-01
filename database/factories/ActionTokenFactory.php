<?php

namespace Database\Factories;

use App\Enums\ActionTokenType;
use App\Models\ActionToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ActionToken>
 */
class ActionTokenFactory extends Factory
{
    protected $model = ActionToken::class;

    public function definition(): array
    {
        return [
            'token' => Str::random(64),

            'tipo' => ActionTokenType::INVITACION,

            'user_id' => User::factory(),

            'payload' => [],

            'expires_at' => now()->addDays(2),

            'used_at' => null,
        ];
    }

    public function usado(): static
    {
        return $this->state(fn () => [
            'used_at' => now(),
        ]);
    }

    public function vencido(): static
    {
        return $this->state(fn () => [
            'expires_at' => now()->subDay(),
        ]);
    }

    public function invitacion(): static
    {
        return $this->state(fn () => [
            'tipo' => ActionTokenType::INVITACION,
        ]);
    }

    public function asignacion(): static
    {
        return $this->state(fn () => [
            'tipo' => ActionTokenType::ASIGNACION,
        ]);
    }

    public function passwordReset(): static
    {
        return $this->state(fn () => [
            'tipo' => ActionTokenType::PASSWORD_RESET,
        ]);
    }
}
