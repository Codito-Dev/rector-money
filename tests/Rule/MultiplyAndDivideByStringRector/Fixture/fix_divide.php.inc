<?php

namespace Rector\Money\Tests\Rule\MultiplyAndDivideByStringRector\Fixture;

use Money\Currency;
use Money\Money;

Money::PLN(500)->divide(2.5);

$divider = 2.5;
(new Money(100, new Currency('PLN')))->divide($divider);

?>
-----
<?php

namespace Rector\Money\Tests\Rule\MultiplyAndDivideByStringRector\Fixture;

use Money\Currency;
use Money\Money;

Money::PLN(500)->divide('2.5');

$divider = 2.5;
(new Money(100, new Currency('PLN')))->divide(sprintf('%.5F', $divider));

?>
