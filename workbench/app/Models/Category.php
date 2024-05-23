<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workbench\App\Observers\CategoryCreated;
use Workbench\App\Observers\CategoryDeleted;
use Workbench\App\Observers\CategoryUpdated;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected $dispatchesEvents = [
        'created' => CategoryCreated::class,
        'updated' => CategoryUpdated::class,
        'deleted' => CategoryDeleted::class,
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
