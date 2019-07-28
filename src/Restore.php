<?php

namespace Baijunyao\LaravelRestful;

trait Restore
{
    public function restore()
    {
        $model = $this->getModelFQCN();
        $resource = $this->getResourceFQCN();

        $currentModel = (new $model)->withTrashed()->find($this->getRouteId());
        $currentModel->restore();

        return new $resource($currentModel);
    }
}
