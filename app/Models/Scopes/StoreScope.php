<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StoreScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * this scope will filter the products by the authenticated user's store_id
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();
        if ($user && $user->store_id) {
            $builder->where('store_id', $user->store_id);
        }
    }
}
