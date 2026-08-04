<?php

namespace App\Enums;

enum RolUsuario: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN_IGLESIA = 'admin-iglesia';
    case LIDER_MINISTERIO = 'lider-ministerio';
    case COORDINADOR = 'coordinador';
    case SERVIDOR = 'servidor';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrador',
            self::ADMIN_IGLESIA => 'Administrador de la iglesia',
            self::LIDER_MINISTERIO => 'Líder de ministerio',
            self::COORDINADOR => 'Coordinador',
            self::SERVIDOR => 'Servidor',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'danger',
            self::ADMIN_IGLESIA => 'warning',
            self::LIDER_MINISTERIO => 'success',
            self::COORDINADOR => 'info',
            self::SERVIDOR => 'gray',
        };
    }

    /**
     * Todos los roles.
     */
    public static function todos(): array
    {
        return array_map(
            fn (self $rol) => $rol->value,
            self::cases(),
        );
    }

    /**
     * Puede administrar toda la aplicación.
     */
    public static function administracionGlobal(): array
    {
        return [
            self::SUPER_ADMIN->value,
        ];
    }

    /**
     * Puede administrar una iglesia completa.
     */
    public static function administracionIglesia(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::ADMIN_IGLESIA->value,
        ];
    }

    /**
     * Puede administrar ministerios.
     */
    public static function ministerios(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::ADMIN_IGLESIA->value,
            self::LIDER_MINISTERIO->value,
        ];
    }

    /**
     * Puede coordinar eventos y servidores.
     */
    public static function coordinacion(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::ADMIN_IGLESIA->value,
            self::LIDER_MINISTERIO->value,
            self::COORDINADOR->value,
        ];
    }

    /**
     * Cualquier usuario autenticado con rol.
     */
    public static function cualquierRol(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::ADMIN_IGLESIA->value,
            self::LIDER_MINISTERIO->value,
            self::COORDINADOR->value,
            self::SERVIDOR->value,
        ];
    }
}
