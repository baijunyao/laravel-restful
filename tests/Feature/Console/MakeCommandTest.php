<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Console;

use Baijunyao\LaravelRestful\Tests\TestCase;
use Illuminate\Support\Facades\File;

class MakeCommandTest extends TestCase
{
    public function testMakeCommand(): void
    {
        $this->artisan('make:restful Article')->assertOk();

        $basePath = $this->app->basePath();

        $files = [
            $basePath . '/app/Models/Article.php',
            $basePath . '/app/Http/Controllers/Resources/Controller.php',
            $basePath . '/app/Http/Controllers/Resources/ArticleController.php',
            $basePath . '/app/Http/Requests/Article/Store.php',
            $basePath . '/app/Http/Requests/Article/Update.php',
            $basePath . '/app/Http/Resources/ArticleCollection.php',
            $basePath . '/app/Http/Resources/ArticleResource.php',
            $basePath . '/app/Http/Resources/Collection.php',
            $basePath . '/app/Http/Resources/Resource.php',
            $basePath . '/database/seeders/ArticleSeeder.php',
            $basePath . '/tests/Feature/Resources/TestCase.php',
            $basePath . '/tests/Feature/Resources/ArticleControllerTest.php',
        ];

        foreach ($files as $file) {
            static::assertFileExists($file);
        }

        $migrations = File::files($basePath . '/database/migrations/');

        $articleMigrations = array_filter(
            $migrations,
            function ($file) {
                return fnmatch('*_create_articles_table.php', $file->getFilename());
            }
        );

        static::assertCount(1, $articleMigrations);

        $articleMigration = current($articleMigrations);

        File::delete(array_merge($files, [$articleMigration->getPathname()]));
        File::deleteDirectory($basePath . '/app/Http/Controllers/Resources');
        File::deleteDirectory($basePath . '/tests/Feature/Resources');
    }

    public function testMakeCommandWithPath(): void
    {
        $this->artisan('make:restful Admin/Article')->assertOk();

        $basePath = $this->app->basePath();

        $files = [
            $basePath . '/app/Models/Article.php',
            $basePath . '/app/Http/Controllers/Admin/Resources/Controller.php',
            $basePath . '/app/Http/Controllers/Admin/Resources/ArticleController.php',
            $basePath . '/app/Http/Requests/Admin/Article/Store.php',
            $basePath . '/app/Http/Requests/Admin/Article/Update.php',
            $basePath . '/app/Http/Resources/Admin/ArticleCollection.php',
            $basePath . '/app/Http/Resources/Admin/ArticleResource.php',
            $basePath . '/app/Http/Resources/Admin/Collection.php',
            $basePath . '/app/Http/Resources/Admin/Resource.php',
            $basePath . '/database/seeders/ArticleSeeder.php',
            $basePath . '/tests/Feature/Admin/Resources/TestCase.php',
            $basePath . '/tests/Feature/Admin/Resources/ArticleControllerTest.php',
        ];

        foreach ($files as $file) {
            static::assertFileExists($file);
        }

        $migrations = File::files($basePath . '/database/migrations/');

        $articleMigrations = array_filter(
            $migrations,
            function ($file) {
                return fnmatch('*_create_articles_table.php', $file->getFilename());
            }
        );

        static::assertCount(1, $articleMigrations);

        $articleMigration = current($articleMigrations);

        File::delete(array_merge($files, [$articleMigration->getPathname()]));
        File::deleteDirectory($basePath . '/app/Http/Controllers/Resources');
        File::deleteDirectory($basePath . '/tests/Feature/Resources');
    }
}
