<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $iglesia_id
 * @property int|null $user_id
 * @property string $nombre
 * @property string $apellido
 * @property string|null $telefono
 * @property string|null $email
 * @property int $activo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asignacion> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DisponibilidadServidor> $disponibilidades
 * @property-read int|null $disponibilidades_count
 * @property-read \App\Models\Iglesia $iglesia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RolServicio> $rolesServicio
 * @property-read int|null $roles_servicio_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ServidorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereIglesiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servidor whereUserId($value)
 * @mixin \Eloquent
 */
class Servidor extends Model
{
    use HasFactory;

    protected $fillable = [
        'iglesia_id',
        'user_id',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'activo',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rolesServicio()
    {
        return $this->belongsToMany(
            RolServicio::class,
            'rol_servicio_servidor'
        );
    }

    public function disponibilidades()
    {
        return $this->hasMany(DisponibilidadServidor::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
