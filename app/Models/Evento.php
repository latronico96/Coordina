<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $iglesia_id
 * @property int|null $evento_recurrente_id
 * @property string $nombre
 * @property Carbon $fecha
 * @property string $hora_inicio
 * @property string $estado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Asignacion> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read EventoRecurrente|null $eventoRecurrente
 * @property-read Iglesia $iglesia
 * @property-read Collection<int, EventoRol> $rolesRequeridos
 * @property-read int|null $roles_requeridos_count
 *
 * @method static \Database\Factories\EventoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereEventoRecurrenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereIglesiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'iglesia_id',
        'evento_recurrente_id',
        'nombre',
        'fecha',
        'hora_inicio',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function eventoRecurrente()
    {
        return $this->belongsTo(EventoRecurrente::class);
    }

    public function rolesRequeridos()
    {
        return $this->hasMany(EventoRol::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
