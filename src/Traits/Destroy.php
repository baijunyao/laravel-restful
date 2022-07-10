<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn;
use Baijunyao\LaravelRestful\Traits\Functions\GetRouteId;
use Illuminate\Http\Response;

trait Destroy
{
    use GetRouteId;
    use GetModelFqcn;

    public function destroy(): Response
    {
        $id    = $this->getRouteId();
        $model = $this->getModelFqcn();

        $model::findOrFail($id)->delete();

        return response()->noContent();
    }
}
