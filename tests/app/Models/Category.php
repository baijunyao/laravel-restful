<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\CategoryCreated;
use App\Observers\CategoryDeleted;
use App\Observers\CategoryUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
