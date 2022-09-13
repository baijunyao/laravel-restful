<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Baijunyao\LaravelRestful\JsonResource;
use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Baijunyao\LaravelRestful\Traits\Functions\WithTrashed;
use Illuminate\Database\Eloquent\SoftDeletes;

trait Update
{
    use GetRouteId;
    use GetModelFqcn;
    use GetResourceFqcn;
    use WithTrashed;

    public function update(): JsonResource
    {
        $this->formRequestValidation('Update');

        $modelFqcn = $this->getModelFqcn();

        if (static::withTrashed()) {
            if (in_array(SoftDeletes::class, class_uses_recursive($modelFqcn), true) === false) {
                throw new LaravelRestfulException('You should add the Illuminate\Database\Eloquent\SoftDeletes trait to the ' . $modelFqcn . ' model.');
            }

            $query = $modelFqcn::withTrashed();
        } else {
            $query = $modelFqcn::query();
        }

        assert($query instanceof \Illuminate\Database\Eloquent\Builder);

        $resourceFqcn  = $this->getResourceFqcn();
        $modelFqcn     = $query->findOrFail($this->getRouteId());
        $modelFqcn->update($this->getFilteredPayload());

        return new $resourceFqcn($modelFqcn, __CLASS__);
    }
}
