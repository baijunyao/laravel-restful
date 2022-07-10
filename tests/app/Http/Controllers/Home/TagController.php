<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Models\Tag;
use Baijunyao\LaravelRestful\RestfulController;
use Baijunyao\LaravelRestful\Traits\Destroy;
use Baijunyao\LaravelRestful\Traits\ForceDelete;
use Baijunyao\LaravelRestful\Traits\Restore;
use Baijunyao\LaravelRestful\Traits\Show;
use Baijunyao\LaravelRestful\Traits\Update;

class TagController extends RestfulController
{
    use Show;
    use Update;
    use Destroy;
    use ForceDelete;
    use Restore;
    protected const MODEL = Tag::class;
}
