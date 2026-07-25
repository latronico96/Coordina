<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    protected $fillable = [
        'nombre',
        'direccion',
        'activo',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function ministerios()
    {
        return $this->hasMany(Ministerio::class);
    }
}
