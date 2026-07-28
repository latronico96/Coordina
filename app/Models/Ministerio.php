<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $iglesia_id
 * @property string $nombre
 * @property string $descripcion
 * @property int $activo
 * @property-read \App\Models\Iglesia $iglesia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RolServicio> $rolesServicio
 * @property-read int|null $roles_servicio_count
 * @method static \Database\Factories\MinisterioFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereIglesiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ministerio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ministerio extends Model
{
    use HasFactory;

    protected $fillable = [
        'iglesia_id',
        'nombre',
        'descripcion',
        'activo',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function rolesServicio()
    {
        return $this->hasMany(RolServicio::class);
    }
}
