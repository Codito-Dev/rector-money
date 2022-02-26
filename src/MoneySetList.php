<?php

declare(strict_types=1);

namespace Rector\Money;

use Rector\Set\Contract\SetListInterface;

final class MoneySetList implements SetListInterface
{
    public const V4 = __DIR__ . '/../config/sets/v4.php';
}
