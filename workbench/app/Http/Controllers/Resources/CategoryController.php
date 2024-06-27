<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers\Resources;

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
    protected ?string $model = Category::class;

    protected array $allowedFilters = [
        'name',
    ];

    protected array $allowedFields = [
        'id',
        'tag_id',
        'name',
    ];

    protected array $allowedSorts = [
        'id',
    ];

    protected array $allowedIncludes = [
        'tag',
    ];
}
