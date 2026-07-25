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
}
