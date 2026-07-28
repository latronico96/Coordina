<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $evento_recurrente_id
 * @property int $rol_servicio_id
 * @property int $cantidad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventoRecurrente $eventoRecurrente
 * @property-read \App\Models\RolServicio $rolServicio
 * @method static \Database\Factories\EventoRecurrenteRolFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol whereEventoRecurrenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol whereRolServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrenteRol whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventoRecurrenteRol extends Model
{
    use HasFactory;

    protected $table = 'evento_recurrente_rols';

    protected $fillable = [
        'evento_recurrente_id',
        'rol_servicio_id',
        'cantidad',
    ];

    public function eventoRecurrente()
    {
        return $this->belongsTo(EventoRecurrente::class);
    }

    public function rolServicio()
    {
        return $this->belongsTo(RolServicio::class);
    }
}
