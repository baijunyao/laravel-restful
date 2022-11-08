<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Tests\Console;

use Baijunyao\LaravelRestful\Tests\TestCase;
use Illuminate\Support\Facades\File;

class MakeCommandTest extends TestCase
{
    public function testMakeCommand(): void
    {
        $this->artisan('restful:make Article')->assertOk();

        $base_path = $this->app->basePath();

        $files = [
            $base_path . '/app/Models/Article.php',
            $base_path . '/app/Http/Controllers/Resources/Controller.php',
            $base_path . '/app/Http/Controllers/Resources/ArticleController.php',
            $base_path . '/app/Http/Requests/Article/Store.php',
            $base_path . '/app/Http/Requests/Article/Update.php',
            $base_path . '/app/Http/Resources/ArticleCollection.php',
            $base_path . '/app/Http/Resources/ArticleResource.php',
            $base_path . '/app/Http/Resources/Collection.php',
            $base_path . '/app/Http/Resources/Resource.php',
            $base_path . '/database/seeders/ArticleSeeder.php',
            $base_path . '/tests/Feature/Resources/TestCase.php',
            $base_path . '/tests/Feature/Resources/ArticleControllerTest.php',
        ];

        foreach ($files as $file) {
            static::assertFileExists($file);
        }

        $migrations = File::files($base_path . '/database/migrations/');

        $article_migrations = array_filter($migrations, function ($file) {
            return fnmatch('*_create_articles_table.php', $file->getFilename());
        });

        static::assertCount(1, $article_migrations);

        $article_migration = current($article_migrations);

        File::delete(array_merge($files, [$article_migration->getPathname()]));
        File::deleteDirectory($base_path . '/app/Http/Controllers/Resources');
        File::deleteDirectory($base_path . '/tests/Feature/Resources');
    }
}
