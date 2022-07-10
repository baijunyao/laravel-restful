<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\TagCreated;
use App\Observers\TagDeleted;
use App\Observers\TagRestored;
use App\Observers\TagUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
