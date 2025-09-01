<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/packages',
    ])

    ->withRules([
        \PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class
    ])

    ->withSkip([
        \PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer::class,
        \PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer::class,
        \PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer::class,
        \PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer::class,
    ])

    ->withPhpCsFixerSets(
        psr12: true,
        phpCsFixer: true,
    )
;