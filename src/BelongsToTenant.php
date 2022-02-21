<?php

namespace Veldman\Tenancy;

use Veldman\Tenancy\Models\Tenant;

trait BelongsToTenant
{
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function bootBelongsToTenant()
    {
        if(auth()->user() != null) {
            static::addGlobalScope(new TenantScope);
        }

        static::creating(function ($model) {
            if (! $model->getAttribute('tenant_id') && !$model->relationLoaded('tenant')) {
                if(auth()->user() != null) {
                    if(auth()->user()->tenant_id == null) {
                        $model->setAttribute('tenant_id', session()->get('tenant_id', 1));
                    } else {
                        $model->setAttribute('tenant_id', auth()->user()->tenant_id);
                    }
                    $model->setRelation('tenant', auth()->user()->tenant);
                }
            }
        });
    }
}