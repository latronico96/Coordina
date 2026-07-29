<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;

abstract class EntidadDeIglesiaResource extends Resource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasRole('super-admin')) {
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
