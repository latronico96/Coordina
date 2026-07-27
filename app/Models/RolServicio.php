<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolServicio extends Model
{
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
