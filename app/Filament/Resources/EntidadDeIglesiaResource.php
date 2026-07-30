<?php

namespace App\Filament\Resources;

use App\Enums\RolUsuario;
use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

abstract class EntidadDeIglesiaResource extends Resource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasRole(RolUsuario::SUPER_ADMIN)) {
            return $query;
        }

        return static::aplicarFiltroIglesia($query, $user);
    }

    protected static function aplicarFiltroIglesia(
        Builder $query,
        User $user,
    ): Builder {
        return $query->where(
            'iglesia_id',
            $user->iglesia_id,
        );
    }
}
