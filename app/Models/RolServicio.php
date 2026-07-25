<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
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
}
