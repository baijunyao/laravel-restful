<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Traits\Functions;

trait WithTrashed
{
    /**
     * @see \Illuminate\Database\Eloquent\SoftDeletes::withTrashed()
     */
    abstract public function withTrashed(): bool;
}
