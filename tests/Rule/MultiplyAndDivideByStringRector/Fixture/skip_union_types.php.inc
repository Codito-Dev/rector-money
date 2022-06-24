<?php

namespace Rector\Money\Tests\Rule\MultiplyAndDivideByStringRector\Fixture;

use Money\Currency;
use Money\Money;
use function mt_rand;

function returnInt(): int
{
    return 1;
}

class UnionReturning
{
    /**
     * @return Money|array|false
     */
    public static function foo()
    {
        $random = mt_rand(0, 10);
        if ($random % 3 === 0) {
            return new Money($random, new Currency('EUR'));
        }
        if ($random === 5) {
            return ['some' => 'other', 'data'];
        }
        return false;
    }

    /**
     * @return Money|array|false
     */
    public function bar()
    {
        return self::foo();
    }
}

$unionReturning = new UnionReturning();
$unionReturning->bar()->divide(1);
$unionReturning->bar()->multiply(2);

UnionReturning::foo()->divide(3);
UnionReturning::foo()->multiply(4);
