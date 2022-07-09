<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

trait Index
{
    use GetRouteId;
    use GetModelFqcn;
    use GetResourceFqcn;

    abstract public function getFilters();

    abstract public function getSorts();

    abstract public function getFields();

    abstract public function getRelations();

    abstract public function getPerPage();

    public function index(): AnonymousResourceCollection
    {
        $collection = QueryBuilder::for($this->getModelFqcn());

        $filters   = $this->getFilters();
        $sorts     = $this->getSorts();
        $fields    = $this->getFields();
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

        $resource = $this->getResourceFqcn();

        return $resource::collection($collection->paginate($this->getPerPage()));
    }
}
