<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetFilters
{
    /**
     * @see \Baijunyao\LaravelRestful\RestfulController::$allowedFilters
     */
    abstract public static function getFilters(): array;
}
