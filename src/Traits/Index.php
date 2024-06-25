<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Traits\Functions\GetResourceCollectionFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\MakeQueryBuilder;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

trait Index
{
    use GetResourceFqcn;
    use GetResourceCollectionFqcn;
    use MakeQueryBuilder;

    public function index(): JsonResource
    {
        return new ($this->getResourceCollectionFqcn())($this->customPaginate($this->makeQueryBuilder(__FUNCTION__)), __CLASS__);
    }

    abstract protected function customPaginate(SpatieQueryBuilder $builder): Paginator|CursorPaginator;
}
