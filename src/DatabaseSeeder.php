<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class DatabaseSeeder extends Seeder
{
    protected string $seederDir;
    protected string $seederNamespace;
    protected string $databaseSeederClassName;

    public function __construct()
    {
        $reflection = new ReflectionClass(static::class);

        $this->seederDir               = dirname($reflection->getFileName());
        $this->seederNamespace         = $reflection->getNamespaceName();
        $this->databaseSeederClassName = $reflection->getName();
    }

    public function run()
    {
        $files = File::files($this->seederDir);

        foreach ($files as $file) {
            $classFQCN = $this->seederNamespace . '\\' . $file->getFilenameWithoutExtension();

            if ($classFQCN !== $this->databaseSeederClassName) {
                $this->call($classFQCN);
            }
        }
    }
}
