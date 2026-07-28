<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $evento_id
 * @property int $evento_rol_id
 * @property int $servidor_id
 * @property string $estado
 * @property string|null $observaciones
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Evento $evento
 * @property-read EventoRol $eventoRol
 * @property-read Servidor $servidor
 *
 * @method static \Database\Factories\AsignacionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereEventoRolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereServidorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asignacion whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'evento_rol_id',
        'servidor_id',
        'estado',
        'observaciones',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function eventoRol()
    {
        return $this->belongsTo(EventoRol::class);
    }

    public function servidor()
    {
        return $this->belongsTo(Servidor::class);
    }
}
