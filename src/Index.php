<?php

namespace Baijunyao\LaravelRestful;

trait Index
{
    public function index()
    {
        $model = $this->getModelFQCN();
        $resource = $this->getResourceFQCN();

        return $resource::collection((new $model)->withTrashed()->paginate());
    }
}
