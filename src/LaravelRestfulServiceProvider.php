<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Baijunyao\LaravelRestful\Console\MakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelRestfulServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCommand::class,
            ]);
        }
    }
}
