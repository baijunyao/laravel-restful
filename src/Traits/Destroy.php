<?php

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Illuminate\Http\Resources\Json\JsonResource;

trait Destroy
{
    public function destroy(): JsonResource
    {
        $id = $this->getRouteId();
        $model = static::getModelFQCN();

        if ($model::destroy($id) === 0) {
            throw new LaravelRestfulException('Destroy Failed');
        }

        $resource = static::getResourceFQCN();

        return new $resource($model::withTrashed()->find($id));
    }
}
