<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected const ID_NOT_FOUND  = 999999;
    protected const TAG_ID        = 1;
    protected const TAG_NAME      = 'laravel restful tag';
    protected const CATEGORY_ID   = 1;
    protected const CATEGORY_NAME = 'laravel restful category';

    protected function getPackageProviders($app)
    {
        return [
            QueryBuilderServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }

    protected function defineDatabaseSeeders()
    {
        DB::table('tags')->insert([
            [
                'id'   => self::TAG_ID,
                'name' => self::TAG_NAME,
            ],
            [
                'id'   => 2,
                'name' => 'test',
            ],
        ]);

        DB::table('categories')->insert([
            [
                'id'          => self::CATEGORY_ID,
                'tag_id'      => 1,
                'name'        => self::CATEGORY_NAME,
                'description' => 'laravel restful category description',
            ],
            [
                'id'          => 2,
                'tag_id'      => 2,
                'name'        => 'test',
                'description' => 'test',
            ],
        ]);
    }
}
