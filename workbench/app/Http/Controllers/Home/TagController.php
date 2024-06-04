<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers\Home;

use Baijunyao\LaravelRestful\RestfulController;
use Baijunyao\LaravelRestful\Traits\Destroy;
use Baijunyao\LaravelRestful\Traits\ForceDelete;
use Baijunyao\LaravelRestful\Traits\Index;
use Baijunyao\LaravelRestful\Traits\Restore;
use Baijunyao\LaravelRestful\Traits\Show;
use Baijunyao\LaravelRestful\Traits\Update;
use Workbench\App\Models\Tag;

class TagController extends RestfulController
{
    use Index;
    use Show;
    use Update;
    use Destroy;
    use ForceDelete;
    use Restore;
    protected ?string $model = Tag::class;
}
