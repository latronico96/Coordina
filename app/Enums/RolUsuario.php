<?php

namespace App\Enums;

enum RolUsuario: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN_IGLESIA = 'admin-iglesia';
    case LIDER_MINISTERIO = 'lider-ministerio';
    case SERVIDOR = 'servidor';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrador',
            self::ADMIN_IGLESIA => 'Administrador de la iglesia',
            self::LIDER_MINISTERIO => 'Líder de ministerio',
            self::SERVIDOR => 'Servidor',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'danger',
            self::ADMIN_IGLESIA => 'warning',
            self::LIDER_MINISTERIO => 'success',
            self::SERVIDOR => 'gray',
        };
    }
}
