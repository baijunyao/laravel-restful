<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

use Illuminate\Database\Eloquent\Model;

trait GetModelFqcn
{
    /**
     * @return class-string<Model>
     */
    abstract public function getModelFqcn(): string;
}
