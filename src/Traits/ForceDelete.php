<?php

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Illuminate\Http\Response;

trait ForceDelete
{
    public function forceDelete(): Response
    {
        $id = $this->getRouteId();
        $model = static::getModelFQCN();

        if (!$model::withTrashed()->find($id)->forceDelete()) {
            throw new LaravelRestfulException('Force Delete Failed');
        }

        return response('');
    }
}
