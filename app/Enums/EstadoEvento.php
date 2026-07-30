<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EstadoEvento: string implements HasColor, HasIcon, HasLabel
{
    case PENDIENTE = 'pendiente';
    case ORGANIZADO = 'organizado';
    case REALIZADO = 'realizado';
    case CANCELADO = 'cancelado';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDIENTE => 'Pendiente',
            self::ORGANIZADO => 'Organizado',
            self::REALIZADO => 'Realizado',
            self::CANCELADO => 'Cancelado',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDIENTE => 'warning',
            self::ORGANIZADO => 'success',
            self::REALIZADO => 'primary',
            self::CANCELADO => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDIENTE => 'heroicon-o-clock',
            self::ORGANIZADO => 'heroicon-o-check-circle',
            self::REALIZADO => 'heroicon-o-check-badge',
            self::CANCELADO => 'heroicon-o-x-circle',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $estado) => [
                $estado->value => $estado->getLabel(),
            ])
            ->all();
    }
}
