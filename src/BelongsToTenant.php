<?php

namespace Veldman\Tenancy;

trait BelongsToTenant
{
    public function tenant()
    {
        return $this->belongsTo(config('tenancy.model'), config('tenancy.key'));
    }

    public static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        $key = config('tenancy.key');

        static::creating(function ($model) use ($key) {
            if (!$model->getAttribute($key)) {
                $model->setAttribute($key, auth()->user()->$key);
            }
        });
    }
}