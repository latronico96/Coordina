<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $servidor_id
 * @property string $fecha
 * @property string|null $motivo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Servidor $servidor
 * @method static \Database\Factories\DisponibilidadServidorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor whereMotivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor whereServidorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DisponibilidadServidor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DisponibilidadServidor extends Model
{
    use HasFactory;

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
