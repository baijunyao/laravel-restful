<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

use Illuminate\Http\Resources\Json\JsonResource;

trait GetResourceFqcn
{
    /**
     * @return class-string<JsonResource>
     */
    abstract public function getResourceFqcn(): string;
}
