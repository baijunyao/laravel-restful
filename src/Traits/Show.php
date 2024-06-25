<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Baijunyao\LaravelRestful\Traits\Functions\MakeQueryBuilder;
use Baijunyao\LaravelRestful\Traits\Functions\WithTrashed;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;

trait Show
{
    use GetRouteId;
    use GetModelFqcn;
    use GetResourceFqcn;
    use WithTrashed;
    use MakeQueryBuilder;

    public function show(): JsonResource
    {
        $modelFqcn          = $this->getModelFqcn();
        $resourceFqcn       = $this->getResourceFqcn();
        $spatieQueryBuilder = $this->makeQueryBuilder(__FUNCTION__);

        if ($this->withTrashed()) {
            if (in_array(SoftDeletes::class, class_uses_recursive($modelFqcn), true) === false) {
                throw new LaravelRestfulException('You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the ' . $modelFqcn . ' model.');
            }

            $spatieQueryBuilder = $spatieQueryBuilder->withTrashed();
        }

        return new $resourceFqcn($spatieQueryBuilder->findOrFail($this->getRouteId()), __CLASS__);
    }
}
