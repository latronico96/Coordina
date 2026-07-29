<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait PerteneceAIglesia
{
    protected static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasRole('super-admin')) {
            return $query;
        }

        return $query->where(
            'iglesia_id',
            $user->iglesia_id,
        );
    }
}
