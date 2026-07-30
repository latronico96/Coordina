<?php

namespace App\Filament\Concerns;

use App\Enums\RolUsuario;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait PerteneceAIglesia
{
    protected static function getEloquentQuery(): Builder
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

        return $query->where(
            'iglesia_id',
            $user->iglesia_id,
        );
    }
}
