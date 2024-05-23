<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers\Admin;

use Baijunyao\LaravelRestful\RestfulController;
use Baijunyao\LaravelRestful\Traits\Destroy;
use Baijunyao\LaravelRestful\Traits\ForceDelete;
use Baijunyao\LaravelRestful\Traits\Index;
use Baijunyao\LaravelRestful\Traits\Restore;
use Baijunyao\LaravelRestful\Traits\Show;
use Baijunyao\LaravelRestful\Traits\Store;
use Baijunyao\LaravelRestful\Traits\Update;

class TagController extends RestfulController
{
    use Index;
    use Show;
    use Store;
    use Update;
    use Destroy;
    use ForceDelete;
    use Restore;
    protected const WITH_TRASHED = true;
}
