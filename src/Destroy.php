<?php

namespace Baijunyao\LaravelRestful;

trait Destroy
{
    public function destroy()
    {
        $model = static::getModelFQCN();
        $id = $this->getRouteId();
        (new $model)->destroy($id);

        return response('');
    }
}
