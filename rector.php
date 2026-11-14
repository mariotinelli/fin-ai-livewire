<?php

declare(strict_types = 1);

use Pest\Rector\Rules\ChainExpectCallsRector;
use Pest\Rector\Rules\ConvertAssertToExpectRector;
use Pest\Rector\Set\PestSetList;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withCache(
        cacheDirectory: __DIR__ . '/storage/framework/cache/rector',
        containerCacheDirectory: __DIR__ . '/storage/framework/cache',
    )
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        __DIR__ . '/bootstrap/cache',
        ChainExpectCallsRector::class,
        ConvertAssertToExpectRector::class,
        ThrowWithPreviousExceptionRector::class,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        codingStyle: true,
    )
    ->withSets([
        PestSetList::CODING_STYLE,
    ])
    ->withPhpSets();
