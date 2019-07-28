<?php

namespace Baijunyao\LaravelRestful;

trait ForceDelete
{
    public function forceDelete()
    {
        $model = static::getModelFQCN();
        $id = $this->getRouteId();
        (new $model)->withTrashed()->find($id)->forceDelete();

        return response('');
    }
}
