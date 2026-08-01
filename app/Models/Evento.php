<?php

namespace App\Models;

use App\Enums\EstadoEvento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property int $iglesia_id
 * @property int|null $evento_recurrente_id
 * @property string $nombre
 * @property Carbon $fecha
 * @property string $hora_inicio
 * @property EstadoEvento $estado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Asignacion> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read EventoRecurrente|null $eventoRecurrente
 * @property-read Iglesia $iglesia
 * @property-read Collection<int, EventoRol> $rolesRequeridos
 * @property-read int|null $roles_requeridos_count
 * @property-read Collection<int, EventoHistorial> $historial
 * @property-read string $google_calendar_event_id
 *
 * @method static \Database\Factories\EventoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereEventoRecurrenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereIglesiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'iglesia_id',
        'evento_recurrente_id',
        'nombre',
        'fecha',
        'hora_inicio',
        'estado',
        'google_calendar_event_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'estado' => EstadoEvento::class,
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function eventoRecurrente()
    {
        return $this->belongsTo(EventoRecurrente::class);
    }

    public function rolesRequeridos()
    {
        return $this->hasMany(EventoRol::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public function historial()
    {
        return $this->hasMany(EventoHistorial::class);
    }

    public function registrarHistorial(
        string $accion,
        string $descripcion
    ): void {
        /** @var User|null $user */
        $user = Auth::user();
        $this->historial()->create([
            'user_id' => $user->id,
            'accion' => $accion,
            'descripcion' => $descripcion,
        ]);
    }

    public function estaPendiente(): bool
    {
        return $this->estado === EstadoEvento::PENDIENTE;
    }

    public function estaOrganizado(): bool
    {
        return $this->estado === EstadoEvento::ORGANIZADO;
    }

    public function estaRealizado(): bool
    {
        return $this->estado === EstadoEvento::REALIZADO;
    }

    public function estaCancelado(): bool
    {
        return $this->estado === EstadoEvento::CANCELADO;
    }

    public function puedeModificarDatos(): bool
    {
        return $this->estaPendiente();
    }

    public function puedeModificarRoles(): bool
    {
        return $this->estaPendiente() && $this->asignaciones()->count() === 0;
    }

    public function puedeModificarAsignaciones(): bool
    {
        return $this->estaPendiente()
            || $this->estaOrganizado();
    }

    public function puedeOrganizar(): bool
    {
        return $this->estaPendiente()
            && $this->estaCompleto();
    }

    public function puedeRealizar(): bool
    {
        return $this->estaOrganizado();
    }

    public function puedeCancelar(): bool
    {
        return ! $this->estaRealizado()
            && ! $this->estaCancelado();
    }

    public function estaCompleto(): bool
    {
        foreach ($this->rolesRequeridos as $rol) {

            if (
                $rol->asignaciones()->count() < $rol->cantidad
            ) {
                return false;
            }
        }

        return true;
    }

    public function puedeCambiarEstado(): bool
    {
        return ! $this->estaRealizado()
            && ! $this->estaCancelado();
    }

    public function porcentajeCompleto(): int
    {
        $roles = $this->rolesRequeridos;

        if ($roles->isEmpty()) {
            return 0;
        }

        $requeridos = $roles->sum('cantidad');

        $asignados = $roles->sum(function ($rol) {
            return min(
                $rol->cantidad,
                $rol->asignaciones()->count()
            );
        });

        return (int) floor(
            ($asignados / $requeridos) * 100
        );
    }

    public function getEstadoLabelAttribute(): string
    {
        return $this->estado->getLabel();
    }
}
