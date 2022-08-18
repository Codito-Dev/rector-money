<?php

declare(strict_types=1);

namespace Codito\Rector\Money\Tests\Rule\CurrencyAvailableWithinToCurrenciesContainsRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix202208\Symplify\SmartFileSystem\SmartFileInfo;

final class CurrencyAvailableWithinToCurrenciesContainsRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $this->doTestFileInfo($fileInfo);
    }

    /**
     * @return Iterator<string, array<int, SmartFileInfo>>
     */
    public function provideData(): Iterator
    {
        return $this->yieldFilesWithPathnameFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
