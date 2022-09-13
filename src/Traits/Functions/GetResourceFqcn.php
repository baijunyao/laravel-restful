<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetResourceFqcn
{
    /**
     * @return class-string<\Illuminate\Http\Resources\Json\JsonResource>
     */
    abstract public function getResourceFqcn(): string;
}
