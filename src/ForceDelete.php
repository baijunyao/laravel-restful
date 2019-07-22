<?php

namespace Baijunyao\LaravelRestful;

trait ForceDelete
{
    public function forceDelete()
    {
        $model = static::getModelFQN();
        $id = $this->getRouteId();
        (new $model)->withTrashed()->find($id)->forceDelete();

        return response('');
    }
}
