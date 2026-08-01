<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionConfirmacion extends Model
{
    protected $fillable = [
        'asignacion_id',
        'usuario_id',
        'respuesta',
        'respondido_at',
    ];

    protected $casts = [
        'respondido_at' => 'datetime',
    ];

    public function asignacion(): BelongsTo
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pendiente(): bool
    {
        return $this->respuesta === 'pendiente';
    }
}
