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

        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        $currentModel = $model::find($this->getRouteId());
        $currentModel->update(request()->all());

        return new $resource($currentModel);
    }
}
