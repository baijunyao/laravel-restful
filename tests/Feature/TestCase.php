<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests;

use App\Providers\RouteServiceProvider;
use Baijunyao\LaravelRestful\LaravelRestfulServiceProvider;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected const ID_NOT_FOUND  = 999999;
    protected const TAG_ID        = DatabaseSeeder::TAG_ID;
    protected const TAG_NAME      = DatabaseSeeder::TAG_NAME;
    protected const CATEGORY_ID   = DatabaseSeeder::CATEGORY_ID;
    protected const CATEGORY_NAME = DatabaseSeeder::CATEGORY_NAME;

    protected $enablesPackageDiscoveries = true;

    protected function getPackageProviders($app)
    {
        return [
            RouteServiceProvider::class,
            QueryBuilderServiceProvider::class,
            LaravelRestfulServiceProvider::class,
        ];
    }

    protected function getBasePath()
    {
        return __DIR__ . '/../skeleton';
    }

    protected function defineDatabaseMigrations()
    {
        $this->artisan('migrate --seed')->run();
    }
}
