<?php

declare(strict_types=1);

use Madbox99\RectorFilament\Set\FilamentSetList;
use Rector\Config\Level\CodeQualityLevel;
use Rector\Config\Level\CodingStyleLevel;
use Rector\Config\Level\DeadCodeLevel;
use Rector\Config\Level\TypeDeclarationLevel;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withImportNames()
    ->withComposerBased()
    ->withPhpSets()
    ->withParallel()
    ->withDeadCodeLevel(level: count(DeadCodeLevel::RULES))
    ->withCodeQualityLevel(level: count(CodeQualityLevel::RULES))
    ->withCodingStyleLevel(level: count(CodingStyleLevel::RULES))
    ->withTypeCoverageLevel(level: count(TypeDeclarationLevel::RULES))
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/tests',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources',
        __DIR__.'/routes',
    ])
    ->withSets([
        FilamentSetList::LARAVEL_APP,
    ]);
