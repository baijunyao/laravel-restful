<?php

namespace Baijunyao\LaravelRestful;

trait Show
{
    public function show()
    {
        $model = $this->getModelFQCN();
        $resource = $this->getResourceFQCN();
        $id = $this->getRouteId();

        return new $resource((new $model)->withTrashed()->find($id));
    }
}
