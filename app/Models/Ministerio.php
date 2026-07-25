<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    protected $fillable = [
        'iglesia_id',
        "nombre",
        "descripcion",
        "activo"
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function rolesServicio()
    {
        return $this->hasMany(RolServicio::class);
    }
}
