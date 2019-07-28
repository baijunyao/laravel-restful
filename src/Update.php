<?php

namespace Baijunyao\LaravelRestful;

trait Update
{
    public function update()
    {
        $this->formRequestValidation('Update');
        $resourceFQCN = $this->getResourceFQCN();
        $model = $this->getModelFQCN();
        $currentModel = (new $model)->withTrashed()->find($this->getRouteId());
        $currentModel->update(request()->all());

        return new $resourceFQCN($currentModel);
    }
}
