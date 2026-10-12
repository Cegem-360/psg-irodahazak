<?php

declare(strict_types=1);

use Madbox99\RectorFilament\Set\FilamentSetList;
use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withImportNames()
    ->withComposerBased(laravel: true)
    ->withParallel()
    ->withPhpSets(php83: true)
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/tests',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources',
        __DIR__.'/routes',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true
    )
    ->withSets([
        LaravelSetList::LARAVEL_130,
        FilamentSetList::LARAVEL_APP,
    ]);
