<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(LevelSetList::UP_TO_PHP_74);
    $containerConfigurator->import(SetList::CODE_QUALITY);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_SHORT_CLASSES, true);
    $parameters->set(Option::PARALLEL, true);
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/ecs.php',
        __DIR__ . '/rector.php',
    ]);
    $parameters->set(Option::SKIP, [
        '*/Fixture/*',
        '*/Source/*',
    ]);
};
