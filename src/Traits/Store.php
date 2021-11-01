<?php

namespace Baijunyao\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Store
{
    /**
     * Store
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function store()
    {
        $this->formRequestValidation('Store');

        $modelFQCN = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        return new $resource($modelFQCN::create($this->getFilteredPayload())->refresh());
    }
}
