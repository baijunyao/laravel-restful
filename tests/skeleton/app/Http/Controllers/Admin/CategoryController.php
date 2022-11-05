<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Baijunyao\LaravelRestful\RestfulController;
use Baijunyao\LaravelRestful\Traits\Show;
use Baijunyao\LaravelRestful\Traits\Update;

class CategoryController extends RestfulController
{
    use Show;
    use Update;
    protected const MODEL        = Category::class;
    protected const WITH_TRASHED = true;
}
