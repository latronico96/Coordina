<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoRol extends Model
{
    protected $fillable = [
        'evento_recurrente_id',
        'rol_servicio_id',
        'cantidad',
    ];

    public function eventoRecurrente()
    {
        return $this->belongsTo(EventoRecurrente::class);
    }

    public function rolServicio()
    {
        return $this->belongsTo(RolServicio::class);
    }
}
