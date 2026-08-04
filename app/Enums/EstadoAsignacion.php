<?php

namespace App\Enums;

enum EstadoAsignacion: string
{
    case PENDIENTE = 'Pendiente';
    case CONFIRMADO = 'Confirmado';
    case RECHAZADO = 'Rechazado';

    public function label(): string
    {
        return match ($this) {
            self::PENDIENTE => 'Pendiente',
            self::CONFIRMADO => 'Confirmado',
            self::RECHAZADO => 'Rechazado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::RECHAZADO => 'danger',
            self::PENDIENTE => 'warning',
            self::CONFIRMADO => 'success',
        };
    }
}
