<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

trait MakeQueryBuilder
{
    /**
     * @see \Baijunyao\LaravelRestful\RestfulController::makeQueryBuilder()
     */
    abstract public function makeQueryBuilder(string $action): SpatieQueryBuilder;
}
