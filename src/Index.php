<?php

namespace Baijunyao\LaravelRestful;

trait Index
{
    public function index()
    {
        $model = $this->getModelFQN();
        $resource = $this->getResourceFQN();

        return $resource::collection((new $model)->withTrashed()->paginate());
    }
}
