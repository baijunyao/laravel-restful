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
        $list = $model::withTrashed()
            ->when(static::ORDER_BY_COLUMN !== null, function ($query) {
                return $query->orderBy(static::ORDER_BY_COLUMN, static::ORDER_BY_DIRECTION);
            })
            ->paginate(static::PER_PAGE);

        return $resource::collection($list);
    }
}
