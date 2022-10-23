<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    $config->parallel();

    $config->import(SetList::PSR_12);
    $config->import(SetList::COMMON);
    $config->import(SetList::CLEAN_CODE);
    $config->import(SetList::NAMESPACES);

    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/config',
        __DIR__ . '/ecs.php',
        __DIR__ . '/phparkitect.php',
        __DIR__ . '/rector.php',
    ]);
    $config->skip([
        // Paths that should not be analysed
        '*/Source/*',
        '*/Fixture/*',

        // Sniffs / Checkers
        CastSpacesFixer::class,
        NotOperatorWithSuccessorSpaceFixer::class,
        AssignmentInConditionSniff::class . '.Found',
    ]);
    $config->lineEnding("\n");
    $config->cacheDirectory('cache/ecs');
};
