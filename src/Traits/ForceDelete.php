<?php

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait ForceDelete
{
    /**
     * Force Delete
     *
     * @return ResponseFactory|Response
     * @throws LaravelRestfulException
     *
     * @author hanmeimei
     */
    public function forceDelete()
    {
        $id = $this->getRouteId();
        $model = static::getModelFQCN();

        if (!$model::withTrashed()->find($id)->forceDelete()) {
            throw new LaravelRestfulException('Force Delete Failed');
        }

        return response('');
    }
}
