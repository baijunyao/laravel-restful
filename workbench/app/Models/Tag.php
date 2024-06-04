<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Workbench\App\Observers\TagCreated;
use Workbench\App\Observers\TagDeleted;
use Workbench\App\Observers\TagRestored;
use Workbench\App\Observers\TagUpdated;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $dispatchesEvents = [
        'created'  => TagCreated::class,
        'updated'  => TagUpdated::class,
        'deleted'  => TagDeleted::class,
        'restored' => TagRestored::class,
    ];

    public function categories(): HasMany
    {
        return $this->HasMany(Category::class);
    }
}
