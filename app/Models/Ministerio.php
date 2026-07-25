<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    protected $fillable = [
        "nombre",
        "descripcion",
        "activo"
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }
}
