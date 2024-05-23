<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers\Home;

use Baijunyao\LaravelRestful\RestfulController;
use Baijunyao\LaravelRestful\Traits\Destroy;
use Baijunyao\LaravelRestful\Traits\ForceDelete;
use Baijunyao\LaravelRestful\Traits\Index;
use Baijunyao\LaravelRestful\Traits\Restore;
use Baijunyao\LaravelRestful\Traits\Show;
use Baijunyao\LaravelRestful\Traits\Store;
use Baijunyao\LaravelRestful\Traits\Update;
use Workbench\App\Models\Category;

class CategoryController extends RestfulController
{
    use Index;
    use Show;
    use Store;
    use Update;
    use Destroy;
    use ForceDelete;
    use Restore;
    protected const MODEL = Category::class;

    protected const FILTERS = [
        'name',
    ];

    protected const FIELDS = [
        'id',
        'tag_id',
        'name',
    ];

    protected const SORTS = [
        'id',
    ];

    protected const RELATIONS = [
        'tag',
    ];
}
