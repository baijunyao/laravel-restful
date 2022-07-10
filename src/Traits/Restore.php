<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;

trait Restore
{
    use GetRouteId;
    use GetModelFqcn;
    use GetResourceFqcn;

    public function restore(): JsonResource
    {
        $model    = $this->getModelFqcn();
        $resource = $this->getResourceFqcn();

        if (in_array(SoftDeletes::class, class_uses_recursive($model), true) === false) {
            throw new LaravelRestfulException('You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the ' . $model . ' model.');
        }

        $currentModel = $model::withTrashed()->findOrFail($this->getRouteId());
        $currentModel->restore();

        return new $resource($currentModel);
    }
}
