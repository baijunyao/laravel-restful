<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetRelations
{
    /**
     * @see \Baijunyao\LaravelRestful\RestfulController::RELATIONS
     */
    abstract public static function getRelations(): array;
}
