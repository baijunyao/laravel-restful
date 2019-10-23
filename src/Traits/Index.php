<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait Index
{
    /**
     * Index
     *
     * @return AnonymousResourceCollection
     *
     * @author hanmeimei
     */
    public function index()
    {
        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        return $resource::collection($model::withTrashed()->paginate());
    }
}
