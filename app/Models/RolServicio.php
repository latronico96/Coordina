<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $ministerio_id
 * @property string $nombre
 * @property int $minutos_preparacion
 * @property int $activo
 * @property-read Collection<int, EventoRol> $eventos
 * @property-read int|null $eventos_count
 * @property-read Collection<int, EventoRecurrenteRol> $eventosRecurrentes
 * @property-read int|null $eventos_recurrentes_count
 * @property-read Ministerio $ministerio
 * @property-read Collection<int, Servidor> $servidores
 * @property-read int|null $servidores_count
 *
 * @method static \Database\Factories\RolServicioFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereMinisterioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereMinutosPreparacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RolServicio whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class RolServicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'ministerio_id',
        'nombre',
        'minutos_preparacion',
        'activo',
    ];

    public function ministerio()
    {
        return $this->belongsTo(Ministerio::class);
    }

    public function eventosRecurrentes()
    {
        return $this->hasMany(EventoRecurrenteRol::class);
    }

    public function eventos()
    {
        return $this->hasMany(EventoRol::class);
    }

    public function servidores()
    {
        return $this->belongsToMany(
            Servidor::class,
            'rol_servicio_servidor'
        );
    }
}
