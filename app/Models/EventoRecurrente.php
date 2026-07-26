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

    public function roles()
    {
        return $this->hasMany(EventoRol::class);
    }
}
