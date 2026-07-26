<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisponibilidadServidor extends Model
{
    protected $fillable = [
        'servidor_id',
        'fecha',
        'motivo',
    ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class);
    }
}
