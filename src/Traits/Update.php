<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Update
{
    public function update(): JsonResource
    {
        $this->formRequestValidation('Update');

        $modelFQCN = static::getModelFQCN();
        $resource  = static::getResourceFQCN();

        $model = $modelFQCN::find($this->getRouteId());
        $model->update($this->getFilteredPayload());

        return new $resource($model);
    }
}
