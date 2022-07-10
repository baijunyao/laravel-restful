<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Illuminate\Http\Resources\Json\JsonResource;

trait Store
{
    use GetRouteId;
    use GetModelFqcn;
    use GetResourceFqcn;

    public function store(): JsonResource
    {
        $this->formRequestValidation('Store');

        $model     = $this->getModelFqcn();
        $resource  = $this->getResourceFqcn();

        return new $resource($model::create($this->getFilteredPayload())->refresh());
    }
}
