<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoHistorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'user_id',
        'accion',
        'descripcion',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
