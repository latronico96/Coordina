<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $evento_id
 * @property int $rol_servicio_id
 * @property int $cantidad
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Asignacion> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read Evento $evento
 * @property-read RolServicio $rolServicio
 *
 * @method static \Database\Factories\EventoRolFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol whereRolServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRol whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class EventoRol extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'rol_servicio_id',
        'cantidad',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function rolServicio()
    {
        return $this->belongsTo(RolServicio::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
