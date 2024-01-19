<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\Extend;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;
use Rector\Rector\AbstractRector;

return static function (Config $config): void {
    $srcClassSet = ClassSet::fromDir(__DIR__ . '/src');

    $rules = [];

    $rectors = Rule::allClasses()->that(new ResideInOneOfTheseNamespaces('Codito\Rector\Money\Rule'));
    $rules[] = $rectors->should(new HaveNameMatching('*Rector'))->because('this is Rector convention');
    $rules[] = $rectors
        ->should(new Extend(AbstractRector::class))
        ->because('we need satisfy Rector\'s contract for rules');

    $config->add($srcClassSet, ...$rules);
};
