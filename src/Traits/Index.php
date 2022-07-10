<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait Index
{
    use GetResourceFqcn;
    use QueryBuilderWrapper;

    abstract public function getPerPage();

    public function index(): AnonymousResourceCollection
    {
        return $this->getResourceFqcn()::collection($this->makeQueryBuilder()->paginate($this->getPerPage()));
    }
}
