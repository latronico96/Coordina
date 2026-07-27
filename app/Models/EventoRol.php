<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoRol extends Model
{
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
