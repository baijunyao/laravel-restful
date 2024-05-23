<?php

declare(strict_types=1);

use Baijunyao\PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests/Feature',
        __DIR__ . '/workbench/app',
        __DIR__ . '/workbench/database',
        __DIR__ . '/workbench/routes',
    ]);

return (new Config())->setFinder($finder);
