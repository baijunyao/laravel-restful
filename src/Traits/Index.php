<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

trait Index
{
    abstract function getFilters();
    abstract function getSorts();
    abstract function getFields();
    abstract function getRelations();

    public function index(): AnonymousResourceCollection
    {
        $collection = QueryBuilder::for(static::getModelFQCN());

        $filters = $this->getFilters();
        $sorts = $this->getSorts();
        $fields = $this->getFields();
        $relations = $this->getRelations();

        if ($filters !== []) {
            $collection->allowedFilters($filters);
        }

        if ($sorts !== []) {
            $collection->allowedSorts($sorts);
        }

        if ($fields !== []) {
            $collection->allowedFields($fields);
        }

        if ($relations !== []) {
            $collection->allowedIncludes($relations);
        }

        $resource = static::getResourceFQCN();

        return $resource::collection($collection->paginate(static::PER_PAGE));
    }
}
