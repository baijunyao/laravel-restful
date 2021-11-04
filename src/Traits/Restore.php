<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Restore
{
    public function restore(): JsonResource
    {
        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        $currentModel = $model::withTrashed()->find($this->getRouteId());
        $currentModel->restore();

        return new $resource($currentModel);
    }
}
