<?php

declare(strict_types=1);

namespace Codito\Rector\Money\Tests;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase as UpstreamRectorTestCase;

abstract class AbstractRectorTestCase extends UpstreamRectorTestCase
{
    /**
     * Fixture provider that can be used with PHPUnit's --testdox (displaying fixture name).
     * @see https://github.com/rectorphp/rector-src/pull/2876
     * @return Iterator<string, array<int, string>>
     */
    protected function yieldFilesWithNamesFromDirectory(string $directory, string $suffix = '*.php.inc'): Iterator
    {
        foreach ($this->yieldFilesFromDirectory($directory, $suffix) as $fixture) {
            yield basename($fixture[0]) => $fixture;
        }
    }
}
