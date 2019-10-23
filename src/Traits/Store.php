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

        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        return new $resource($model::create(request()->all()));
    }
}
