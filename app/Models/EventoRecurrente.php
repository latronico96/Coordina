<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoRecurrente extends Model
{
    protected $fillable = [
        'iglesia_id',
        'nombre',
        'dia_semana',
        'hora_inicio',
        'activo',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function rolesRequeridos()
    {
        return $this->hasMany(EventoRecurrenteRol::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
