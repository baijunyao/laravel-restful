<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Workbench\Database\Seeders\CategorySeeder;
use Workbench\Database\Seeders\TagSeeder;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithWorkbench;

    protected const ID_NOT_FOUND  = 999999;
    protected const TAG_ID        = TagSeeder::TAG_ID;
    protected const TAG_NAME      = TagSeeder::TAG_NAME;
    protected const CATEGORY_ID   = CategorySeeder::CATEGORY_ID;
    protected const CATEGORY_NAME = CategorySeeder::CATEGORY_NAME;

    protected $enablesPackageDiscoveries = true;
}
