<?php

namespace Veldman\Tenancy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, $model)
    {
        if(auth()->user()->tenant_id != null) {
            $builder->where('tenant_id', '=', auth()->user()->tenant_id);
        }
    }

    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenancy', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
