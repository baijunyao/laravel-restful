<?php

declare(strict_types=1);

use Baijunyao\PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests/Feature',
        __DIR__ . '/tests/skeleton/app',
        __DIR__ . '/tests/skeleton/database',
        __DIR__ . '/tests/skeleton/routes',
    ]);

return (new Config())->setFinder($finder);
