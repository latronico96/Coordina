<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
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
}
