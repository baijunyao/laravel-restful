<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetFields
{
    /**
     * @see \Baijunyao\LaravelRestful\RestfulController::FIELDS
     */
    abstract public static function getFields(): array;
}
