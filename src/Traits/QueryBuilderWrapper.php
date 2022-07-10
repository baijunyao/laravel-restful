<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

trait QueryBuilderWrapper
{
    use GetModelFqcn;

    abstract public function getFilters();

    abstract public function getSorts();

    abstract public function getFields();

    abstract public function getRelations();

    public function makeQueryBuilder(EloquentBuilder $builder = null): SpatieQueryBuilder
    {
        $spatie_query_builder = SpatieQueryBuilder::for($builder ?? $this->getModelFqcn());

        $filters   = $this->getFilters();
        $sorts     = $this->getSorts();
        $fields    = $this->getFields();
        $relations = $this->getRelations();

        if ($filters !== []) {
            $spatie_query_builder->allowedFilters($filters);
        }

        if ($sorts !== []) {
            $spatie_query_builder->allowedSorts($sorts);
        }

        if ($fields !== []) {
            $spatie_query_builder->allowedFields($fields);
        }

        if ($relations !== []) {
            $spatie_query_builder->allowedIncludes($relations);
        }

        return $spatie_query_builder;
    }
}
