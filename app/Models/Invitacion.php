<?php

namespace App\Models;

use App\Enums\RolUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $iglesia_id
 * @property int|null $user_id
 * @property string $email
 * @property RolUsuario $rol
 * @property string $token
 * @property Carbon $expires_at
 * @property Carbon|null $accepted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Iglesia $iglesia
 * @property-read User|null $user
 *
 * @method static \Database\Factories\InvitacionFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Invitacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'iglesia_id',
        'user_id',
        'email',
        'rol',
        'token',
        'expires_at',
        'accepted_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rol' => RolUsuario::class,
    ];

    public function iglesia(): BelongsTo
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function esValida(): bool
    {
        return ! $this->accepted_at
            && $this->expires_at->isFuture();
    }

    public function estado(): string
    {
        if ($this->accepted_at) {
            return 'aceptada';
        }

        if ($this->expires_at->isPast()) {
            return 'vencida';
        }

        return 'pendiente';
    }
}
