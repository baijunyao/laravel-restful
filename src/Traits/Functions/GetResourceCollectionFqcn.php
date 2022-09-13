<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetResourceCollectionFqcn
{
    /**
     * @return class-string<\Illuminate\Http\Resources\Json\ResourceCollection>
     */
    abstract public function getResourceCollectionFqcn(): string;
}
