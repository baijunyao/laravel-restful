<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Show
{
    /**
     * Show
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function show()
    {
        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        return new $resource($model::withTrashed()->find($this->getRouteId()));
    }
}
