<?php

declare(strict_types=1);

use Codito\Rector\Money\Rule\CurrencyAvailableWithinToCurrenciesContainsRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $config): void {
    $config->import(__DIR__ . '/../../../../config/config.php');
    $config->rule(CurrencyAvailableWithinToCurrenciesContainsRector::class);
};
