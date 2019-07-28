<?php

namespace Baijunyao\LaravelRestful;

trait Store
{
    public function store()
    {
        $this->formRequestValidation('Store');
        $resourceFQCN = $this->getResourceFQCN();
        $model = $this->getModelFQCN();

        return new $resourceFQCN((new $model)->create(request()->all()));
    }
}
