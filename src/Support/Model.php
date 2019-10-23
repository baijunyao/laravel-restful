<?php

namespace Baijunyao\LaravelRestful\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Model
 *
 * @author  hanmeimei
 *
 * @package Baijunyao\LaravelRestful\Traits
 *
 * @mixin Builder
 */
abstract class Model extends BaseModel
{
    use SoftDeletes;
}