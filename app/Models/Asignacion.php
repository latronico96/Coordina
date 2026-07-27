<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $fillable = [
        'evento_id',
        'evento_rol_id',
        'servidor_id',
        'estado',
        'observaciones',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function eventoRol()
    {
        return $this->belongsTo(EventoRol::class);
    }

    public function servidor()
    {
        return $this->belongsTo(Servidor::class);
    }
}
