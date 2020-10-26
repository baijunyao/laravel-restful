<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

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
        $collection = QueryBuilder::for(static::getModelFQCN());

        if (static::FILTERS !== []) {
            $collection->allowedFilters(static::FILTERS);
        }

        if (static::SORTS !== []) {
            $collection->allowedSorts(static::SORTS);
        }

        if (static::FIELDS !== []) {
            $collection->allowedFields(static::FIELDS);
        }

        if (static::RELATIONS !== []) {
            $collection->allowedIncludes(static::RELATIONS);
        }

        $resource = static::getResourceFQCN();

        return $resource::collection($collection->paginate(static::PER_PAGE));
    }
}
