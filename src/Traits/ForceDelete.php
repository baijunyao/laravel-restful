<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Response;

trait ForceDelete
{
    use GetRouteId;
    use GetModelFqcn;

    public function forceDelete(): Response
    {
        $id    = $this->getRouteId();
        $model = $this->getModelFqcn();

        if (in_array(SoftDeletes::class, class_uses_recursive($model), true) === false) {
            throw new LaravelRestfulException('You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the ' . $model . ' model.');
        }

        $model::withTrashed()->findOrFail($id)->forceDelete();

        return response()->noContent();
    }
}
