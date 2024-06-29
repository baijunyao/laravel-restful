<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCommand extends Command
{
    protected $signature   = 'make:restful {name}';
    protected $description = 'Make restful files';

    public function handle(): int
    {
        // e.g. 'User' or 'Admin/User'
        $nameWithPrefix = $this->argument('name');

        $prefix          = '';
        $namespacePrefix = '';
        $pathPrefix      = '';

        if (Str::contains($nameWithPrefix, '/')) {
            // e.g. Admin or ''
            $prefix  = Str::beforeLast($nameWithPrefix, '/');

            // e.g. \Admin or ''
            $namespacePrefix = '\\' . $prefix;

            // e.g. /admin or ''
            $pathPrefix = '/' . $prefix;
        }

        $appPath = $this->laravel->path();

        if (Str::contains($nameWithPrefix, '/')) {
            $name = Str::afterLast($nameWithPrefix, '/');

            // e.g. /app/Http/Controllers/Admin/Resources
            $controllerPath = $appPath . '/Http/Controllers/' . $prefix . '/Resources';
        } else {
            $name           = $nameWithPrefix;
            $controllerPath = $appPath . '/Http/Controllers/Resources';
        }

        $stubPath = __DIR__ . '/../../stubs';

        /**
         * Controller
         */
        if (File::isDirectory($controllerPath) === false) {
            File::makeDirectory($controllerPath, 0755, true);
        }

        $this->createFile(
            $stubPath . '/controller.base.stub',
            $controllerPath . '/Controller.php',
            ['{{ path }}'],
            [$namespacePrefix . '\\Resources']
        );

        $controllerName = $name . 'Controller';

        $this->createFile(
            $stubPath . '/controller.stub',
            $controllerPath . '/' . $controllerName . '.php',
            ['{{class}}', '{{path}}'],
            [$controllerName, $namespacePrefix . '\\Resources']
        );

        /**
         * Resource
         */
        $resourcesPath = $appPath . '/Http/Resources' . $pathPrefix;

        if (File::isDirectory($resourcesPath) === false) {
            File::makeDirectory($resourcesPath, 0755, true);
        }

        $this->createFile(
            $stubPath . '/resource.base.stub',
            $resourcesPath . '/Resource.php',
            ['{{path}}'],
            [$namespacePrefix]
        );

        $this->createFile(
            $stubPath . '/collection.base.stub',
            $resourcesPath . '/Collection.php',
            ['{{path}}'],
            [$namespacePrefix]
        );

        $resourceName = $name . 'Resource';

        $this->createFile(
            $stubPath . '/resource.stub',
            $resourcesPath . '/' . $resourceName . '.php',
            ['{{class}}', '{{path}}'],
            [$resourceName, $namespacePrefix]
        );

        $collectionName = $name . 'Collection';

        $this->createFile(
            $stubPath . '/collection.stub',
            $resourcesPath . '/' . $collectionName . '.php',
            ['{{class}}', '{{path}}'],
            [$collectionName, $namespacePrefix]
        );

        /**
         * Test
         */
        $testPath = $this->laravel->basePath('tests/Feature' . $pathPrefix . '/Resources');

        if (File::isDirectory($testPath) === false) {
            File::makeDirectory($testPath, 0755, true);
        }

        $this->createFile(
            $stubPath . '/test.base.stub',
            $testPath . '/TestCase.php',
            ['{{path}}'],
            [$namespacePrefix]
        );

        $testName = $controllerName . 'Test';

        $this->createFile(
            $stubPath . '/test.stub',
            $testPath . '/' . $testName . '.php',
            ['{{class}}', '{{path}}'],
            [$testName, $namespacePrefix]
        );

        // model, migration, seeder
        $this->call('make:model', [
            'name' => $name,
            '-m'   => true,
            '-s'   => true,
        ]);

        // request
        $this->call('make:request', [
            'name' => $nameWithPrefix . '/Store',
        ]);

        $this->call('make:request', [
            'name' => $nameWithPrefix . '/Update',
        ]);

        return self::SUCCESS;
    }

    public function createFile(string $stubFile, string $targetFile, array $placeholder, array $replace): void
    {
        if (File::exists($targetFile)) {
            $this->warn($targetFile . ' already exists!');
        } else {
            File::put($targetFile, str_replace($placeholder, $replace, File::get($stubFile)));
        }
    }
}
