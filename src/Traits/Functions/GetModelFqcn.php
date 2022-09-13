<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait GetModelFqcn
{
    /**
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    abstract public function getModelFqcn(): string;
}
