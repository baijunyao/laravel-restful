<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Baijunyao\LaravelRestful\Traits\Functions\WithTrashed;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;

trait Update
{
    use GetRouteId;
    use GetModelFqcn;
    use GetResourceFqcn;
    use WithTrashed;

    public function update(): JsonResource
    {
        $this->formRequestValidation('Update');

        $model = $this->getModelFqcn();

        if ($this->withTrashed()) {
            if (in_array(SoftDeletes::class, class_uses_recursive($model), true) === false) {
                throw new LaravelRestfulException('You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the ' . $model . ' model.');
            }

            $query = $model::withTrashed();
        } else {
            $query = $model::query();
        }

        assert($query instanceof \Illuminate\Database\Eloquent\Builder);

        $resource  = $this->getResourceFqcn();
        $model     = $query->findOrFail($this->getRouteId());
        $model->update($this->getFilteredPayload());

        return new $resource($model);
    }
}
