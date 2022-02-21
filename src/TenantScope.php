<?php

namespace Veldman\Tenancy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, $model)
    {
        $key = config('tenancy.key');

        if(auth()->user()->$key != null) {
            $builder->where($key, '=', auth()->user()->$key);
        }
    }

    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenancy', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
