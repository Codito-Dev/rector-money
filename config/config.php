<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $config): void {
    $services = $config->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Codito\\Rector\\Money\\', __DIR__ . '/../src')
        ->exclude([__DIR__ . '/../src/{Rule}']);
};
