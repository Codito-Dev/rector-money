<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::COMMON);
    $containerConfigurator->import(SetList::CLEAN_CODE);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::CACHE_DIRECTORY, 'cache/ecs');
    $parameters->set(Option::PARALLEL, true);

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/config',
        __DIR__ . '/ecs.php',
        __DIR__ . '/rector.php',
    ]);

    $parameters->set(Option::SKIP, [
        // Paths that should not be analysed
        '*/Source/*',
        '*/Fixture/*',

        // Sniffs / Checkers
        CastSpacesFixer::class,
        NotOperatorWithSuccessorSpaceFixer::class,
        AssignmentInConditionSniff::class . '.Found',
    ]);

    $parameters->set(Option::LINE_ENDING, "\n");
};
