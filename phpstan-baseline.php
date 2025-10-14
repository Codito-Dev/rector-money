<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Doing instanceof PHPStan\\\\Type\\\\TypeWithClassName is error\\-prone and deprecated\\. Use Type\\:\\:getObjectClassNames\\(\\) or Type\\:\\:getObjectClassReflections\\(\\) instead\\.$#',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Rule/CurrencyAvailableWithinToCurrenciesContainsRector.php',
];
$ignoreErrors[] = [
	'message' => '#^Asking about instanceof PHPStan\\\\Analyser\\\\MutatingScope is not covered by backward compatibility promise\\. The class might change in a minor PHPStan version\\.$#',
	'identifier' => 'phpstanApi.class',
	'count' => 1,
	'path' => __DIR__ . '/src/Rule/MultiplyAndDivideByStringRector.php',
];
$ignoreErrors[] = [
	'message' => '#^Doing instanceof PHPStan\\\\Type\\\\ObjectType is error\\-prone and deprecated\\. Use Type\\:\\:isObject\\(\\) or Type\\:\\:getObjectClassNames\\(\\) instead\\.$#',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Rule/MultiplyAndDivideByStringRector.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
