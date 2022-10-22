<?php

declare(strict_types=1);

namespace Codito\Rector\Money\Tests\Rule\CurrencyAvailableWithinToCurrenciesContainsRector;

use Codito\Rector\Money\Tests\AbstractRectorTestCase;
use Iterator;

final class CurrencyAvailableWithinToCurrenciesContainsRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $fileInfo): void
    {
        $this->doTestFile($fileInfo);
    }

    /**
     * @return Iterator<string, array<int, string>>
     */
    public function provideData(): Iterator
    {
        return $this->yieldFilesWithNamesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
