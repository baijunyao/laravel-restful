<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restful:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make restful files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name            = $this->argument('name');
        $app_path        = $this->laravel->path();
        $controller_path = $app_path . '/Http/Controllers/Resources';
        $stub_path       = __DIR__ . '/../../stubs';

        // controller
        if (File::isDirectory($controller_path) === false) {
            File::makeDirectory($controller_path, 0755, true);
        }

        $base_controller_file = $controller_path . '/Controller.php';

        if (File::exists($base_controller_file) === false) {
            File::put($base_controller_file, File::get($stub_path . '/controller.base.stub'));
        }

        $controller_name = $name . 'Controller';
        $controller_file = $controller_path . '/' . $controller_name . '.php';

        if (File::exists($controller_file) === false) {
            File::put(
                $controller_file,
                str_replace('{{class}}', $controller_name, File::get($stub_path . '/controller.stub'))
            );
        }

        // resource
        $resources_path = $app_path . '/Http/Resources';

        if (File::isDirectory($resources_path) === false) {
            File::makeDirectory($resources_path, 0755, true);
        }

        $base_resource_file = $resources_path . '/Resource.php';

        if (File::exists($base_resource_file) === false) {
            File::put($base_resource_file, File::get($stub_path . '/resource.base.stub'));
        }

        $base_collection_file = $resources_path . '/Collection.php';

        if (File::exists($base_collection_file) === false) {
            File::put($base_collection_file, File::get($stub_path . '/collection.base.stub'));
        }

        $resource_name = $name . 'Resource';
        $resource_file = $resources_path . '/' . $resource_name . '.php';

        if (File::exists($resource_file) === false) {
            File::put(
                $resource_file,
                str_replace('{{class}}', $resource_name, File::get($stub_path . '/resource.stub'))
            );
        }

        $collection_name = $name . 'Collection';
        $collection_file = $resources_path . '/' . $collection_name . '.php';

        if (File::exists($collection_file) === false) {
            File::put(
                $collection_file,
                str_replace('{{class}}', $collection_name, File::get($stub_path . '/collection.stub'))
            );
        }

        // test
        $test_path = $this->laravel->basePath('tests/Feature/Resources');

        if (File::isDirectory($test_path) === false) {
            File::makeDirectory($test_path, 0755, true);
        }

        $base_test_file = $test_path . '/TestCase.php';

        if (File::exists($base_test_file) === false) {
            File::put($base_test_file, File::get($stub_path . '/test.base.stub'));
        }

        $test_name = $controller_name . 'Test';
        $test_file = $test_path . '/' . $test_name . '.php';

        if (File::exists($test_file) === false) {
            File::put(
                $test_file,
                str_replace('{{class}}', $test_name, File::get($stub_path . '/test.stub'))
            );
        }

        // model, migration, seeder
        $this->call('make:model', [
            'name' => $name,
            '-m'   => true,
            '-s'   => true,
        ]);

        // request
        $this->call('make:request', [
            'name' => $name . '/Store',
        ]);

        $this->call('make:request', [
            'name' => $name . '/Update',
        ]);

        return self::SUCCESS;
    }
}
