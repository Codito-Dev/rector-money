<?php

declare(strict_types=1);

use Codito\Rector\Money\Rule\MultiplyAndDivideByStringRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $config): void {
    $config->ruleWithConfiguration(MultiplyAndDivideByStringRector::class, [
        MultiplyAndDivideByStringRector::PRECISION => 5,
    ]);
};
