<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetSorts
{
    /**
     * @see \Baijunyao\LaravelRestful\RestfulController::$allowedSorts
     */
    abstract public static function getSorts();
}
