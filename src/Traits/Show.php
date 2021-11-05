<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Show
{
    public function show(): JsonResource
    {
        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        return new $resource($model::withTrashed()->find($this->getRouteId()));
    }
}
