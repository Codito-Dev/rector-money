<?php

declare(strict_types=1);

namespace Codito\Rector\Money;

use Rector\Set\Contract\SetProviderInterface;
use Rector\Set\ValueObject\Set;

final class MoneySetProvider implements SetProviderInterface
{
    public function provide(): array
    {
        return [
            new Set('moneyphp/money', 'Money v4', MoneySetList::V4),
        ];
    }
}
