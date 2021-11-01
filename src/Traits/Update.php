<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Update
{
    /**
     * Update
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function update()
    {
        $this->formRequestValidation('Update');

        $modelFQCN = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        $model = $modelFQCN::find($this->getRouteId());
        $model->update($this->getFilteredPayload());

        return new $resource($model);
    }
}
