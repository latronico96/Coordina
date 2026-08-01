<?php

namespace App\Services;

use App\Enums\ActionTokenType;
use App\Models\ActionToken;
use App\Models\User;
use Illuminate\Support\Str;

class ActionTokenService
{
    public function crear(
        ActionTokenType $tipo,
        ?User $user = null,
        array $payload = [],
        int $dias = 2,
    ): ActionToken {

        return ActionToken::create([
            'token' => Str::random(64),

            'tipo' => $tipo->value,

            'user_id' => $user?->id,

            'payload' => $payload,

            'expires_at' => now()->addDays($dias),
        ]);
    }

    public function buscar(
        string $token,
    ): ?ActionToken {

        return ActionToken::query()
            ->where('token', $token)
            ->first();
    }

    public function valido(
        ActionToken $token,
    ): bool {

        return $token->valido();
    }

    public function marcarComoUsado(
        ActionToken $token,
    ): void {

        $token->update([
            'used_at' => now(),
        ]);
    }

    public function renovar(
        ActionToken $token,
        int $dias = 2,
    ): ActionToken {

        $token->update([
            'token' => Str::random(64),
            'used_at' => null,
            'expires_at' => now()->addDays($dias),
        ]);

        return $token;
    }

    public function revocar(
        ActionToken $token,
    ): void {

        $token->update([
            'used_at' => now(),
        ]);
    }
}
