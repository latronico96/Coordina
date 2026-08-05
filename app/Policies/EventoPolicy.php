<?php

namespace App\Policies;

use App\Enums\RolUsuario;
use App\Models\Evento;
use App\Models\User;

class EventoPolicy
{
    /**
     * El usuario puede ver el listado de eventos.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(RolUsuario::ministerios());
    }

    /**
     * El usuario puede ver un evento.
     */
    public function view(User $user, Evento $evento): bool
    {
        if ($user->hasRole(RolUsuario::administracionGlobal())) {
            return true;
        }

        return $user->iglesia_id === $evento->iglesia_id;
    }

    /**
     * Crear eventos.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(RolUsuario::administracionIglesia());
    }

    /**
     * Editar eventos.
     */
    public function update(User $user, Evento $evento): bool
    {
        if ($user->hasRole(RolUsuario::administracionGlobal())) {
            return true;
        }

        if ($user->iglesia_id !== $evento->iglesia_id) {
            return false;
        }

        return $evento->puedeModificarDatos()
            || $evento->puedeModificarAsignaciones();
    }

    /**
     * Borrar eventos.
     */
    public function delete(User $user, Evento $evento): bool
    {
        if ($user->hasRole(RolUsuario::administracionGlobal())) {
            return true;
        }

        return $user->iglesia_id === $evento->iglesia_id
            && $evento->estaPendiente();
    }

    public function restore(User $user, Evento $evento): bool
    {
        return false;
    }

    public function forceDelete(User $user, Evento $evento): bool
    {
        return false;
    }
}
