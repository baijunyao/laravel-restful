<?php

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait Destroy
{
    /**
     * Destroy
     *
     * @return ResponseFactory|Response
     * @throws LaravelRestfulException
     *
     * @author hanmeimei
     */
    public function destroy()
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
