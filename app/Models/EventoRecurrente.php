<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $iglesia_id
 * @property string $nombre
 * @property int $dia_semana
 * @property string $hora_inicio
 * @property int $activo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Evento> $eventos
 * @property-read int|null $eventos_count
 * @property-read Iglesia $iglesia
 * @property-read Collection<int, EventoRecurrenteRol> $rolesRequeridos
 * @property-read int|null $roles_requeridos_count
 *
 * @method static \Database\Factories\EventoRecurrenteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereDiaSemana($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereIglesiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventoRecurrente whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class EventoRecurrente extends Model
{
    use HasFactory;

    protected $fillable = [
        'iglesia_id',
        'nombre',
        'dia_semana',
        'hora_inicio',
        'activo',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function rolesRequeridos()
    {
        return $this->hasMany(EventoRecurrenteRol::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function proximaFecha(): Carbon
    {
        $desde = Carbon::today();

        return match ($this->dia_semana) {
            1 => $desde->copy()->next(Carbon::MONDAY),
            2 => $desde->copy()->next(Carbon::TUESDAY),
            3 => $desde->copy()->next(Carbon::WEDNESDAY),
            4 => $desde->copy()->next(Carbon::THURSDAY),
            5 => $desde->copy()->next(Carbon::FRIDAY),
            6 => $desde->copy()->next(Carbon::SATURDAY),
            7 => $desde->copy()->next(Carbon::SUNDAY),
        };
    }
}
