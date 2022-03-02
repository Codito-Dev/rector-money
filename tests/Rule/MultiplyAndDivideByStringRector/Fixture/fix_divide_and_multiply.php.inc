<?php

namespace Rector\Money\Tests\Rule\MultiplyAndDivideByStringRector\Fixture;

use Money\Currency;
use Money\Money;

function returnFloat(): float
{
    return 0.5;
}

class FloatReturning
{
    public static function foo(): float
    {
        return 4.0;
    }

    public function bar(): float
    {
        return 1.0;
    }
}

Money::PLN(500)->divide(2.5);

$divider = 2.5;
(new Money(100, new Currency('PLN')))->divide($divider);

Money::PLN(500)->multiply(returnFloat());
Money::PLN(500)->multiply(FloatReturning::foo());
Money::PLN(500)->multiply((new FloatReturning())->bar());

?>
-----
<?php

namespace Rector\Money\Tests\Rule\MultiplyAndDivideByStringRector\Fixture;

use Money\Currency;
use Money\Money;

function returnFloat(): float
{
    return 0.5;
}

class FloatReturning
{
    public static function foo(): float
    {
        return 4.0;
    }

    public function bar(): float
    {
        return 1.0;
    }
}

Money::PLN(500)->divide('2.5');

$divider = 2.5;
(new Money(100, new Currency('PLN')))->divide(sprintf('%.5F', $divider));

Money::PLN(500)->multiply(sprintf('%.5F', returnFloat()));
Money::PLN(500)->multiply(sprintf('%.5F', FloatReturning::foo()));
Money::PLN(500)->multiply(sprintf('%.5F', (new FloatReturning())->bar()));

?>
