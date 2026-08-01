<?php

namespace App\Models;

use App\Enums\ActionTokenType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $token
 * @property ActionTokenType $tipo
 * @property int|null $user_id
 * @property array $payload
 * @property Carbon $expires_at
 * @property Carbon|null $used_at
 * @property-read User|null $user
 */
class ActionToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'tipo',
        'user_id',
        'payload',
        'expires_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
            'tipo' => ActionTokenType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function usado(): bool
    {
        return $this->used_at !== null;
    }

    public function expirado(): bool
    {
        return $this->expires_at->isPast();
    }

    public function valido(): bool
    {
        return ! $this->usado()
            && ! $this->expirado();
    }
}
