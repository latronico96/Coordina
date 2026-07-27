<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'iglesia_id',
        'evento_recurrente_id',
        'nombre',
        'fecha',
        'hora_inicio',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function eventoRecurrente()
    {
        return $this->belongsTo(EventoRecurrente::class);
    }

    public function rolesRequeridos()
    {
        return $this->hasMany(EventoRol::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
