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
        foreach ($payload as $campo => $valor) {
            $this->revocarPorPayload($tipo, $campo, $valor);
        }

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

    public function buscarPorPayload(
        ActionTokenType $tipo,
        string $campo,
        mixed $valor,
    ): ?ActionToken {
        return ActionToken::query()
            ->where('tipo', $tipo)
            ->whereJsonContains("payload->{$campo}", $valor)
            ->whereNull('used_at')
            ->latest()
            ->first();
    }

    public function revocarPorPayload(
        ActionTokenType $tipo,
        string $campo,
        mixed $valor,
    ): void {
        ActionToken::query()
            ->where('tipo', $tipo)
            ->whereJsonContains("payload->{$campo}", $valor)
            ->whereNull('used_at')
            ->update([
                'used_at' => now(),
            ]);
    }
}
