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
 * @property string $nombre
 * @property string|null $direccion
 * @property int $activo
 * @property-read Collection<int, Evento> $eventos
 * @property-read int|null $eventos_count
 * @property-read Collection<int, EventoRecurrente> $eventosRecurrentes
 * @property-read int|null $eventos_recurrentes_count
 * @property-read Collection<int, Ministerio> $ministerios
 * @property-read int|null $ministerios_count
 * @property-read Collection<int, Servidor> $servidores
 * @property-read int|null $servidores_count
 * @property-read Collection<int, User> $usuarios
 * @property-read int|null $usuarios_count
 *
 * @method static \Database\Factories\IglesiaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iglesia whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Iglesia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'activo',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function ministerios()
    {
        return $this->hasMany(Ministerio::class);
    }

    public function servidores()
    {
        return $this->hasMany(Servidor::class);
    }

    public function eventosRecurrentes()
    {
        return $this->hasMany(EventoRecurrente::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
