<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Store
{
    public function store(): JsonResource
    {
        $this->formRequestValidation('Store');

        $modelFQCN = static::getModelFQCN();
        $resource  = static::getResourceFQCN();

        return new $resource($modelFQCN::create($this->getFilteredPayload())->refresh());
    }
}
