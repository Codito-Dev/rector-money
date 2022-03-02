<?php

namespace Rector\Money\Tests\Rule\MultiplyAndDivideByStringRector\Fixture;

use Money\Currency;
use Money\Money;

function returnInt(): int
{
    return 1;
}

class IntReturning
{
    public static function foo(): int
    {
        return 4;
    }

    public function bar(): int
    {
        return 1;
    }
}

Money::PLN(500)->multiply(5);

$multiplier = '2.5';
(new Money(100, new Currency('PLN')))->multiply($multiplier);

Money::PLN(500)->divide('5.0');

Money::PLN(500)->multiply(returnInt());
Money::PLN(500)->multiply(IntReturning::foo());
Money::PLN(500)->multiply((new IntReturning())->bar());

