<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers\Admin;

use Baijunyao\LaravelRestful\RestfulController;
use Baijunyao\LaravelRestful\Traits\Show;
use Baijunyao\LaravelRestful\Traits\Update;
use Workbench\App\Models\Category;

class CategoryController extends RestfulController
{
    use Show;
    use Update;
    protected const MODEL        = Category::class;
    protected const WITH_TRASHED = true;
}
