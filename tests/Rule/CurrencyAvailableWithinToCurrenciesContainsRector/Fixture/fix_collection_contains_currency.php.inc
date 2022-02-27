<?php

namespace Rector\Money\Tests\Rule\CurrencyAvailableWithinToCurrenciesContainsRector\Fixture;

use Money\Currencies\CurrencyList;
use Money\Currency;

$collection = new CurrencyList([new Currency('PLN')]);
$currency = new Currency('EUR');
$otherCurrency = new Currency('EUR');

if ($currency->isAvailableWithin($collection)) {
    echo 'Yes!';
}

$isInCollection = $otherCurrency->isAvailableWithin($collection);

?>
-----
<?php

namespace Rector\Money\Tests\Rule\CurrencyAvailableWithinToCurrenciesContainsRector\Fixture;

use Money\Currencies\CurrencyList;
use Money\Currency;

$collection = new CurrencyList([new Currency('PLN')]);
$currency = new Currency('EUR');
$otherCurrency = new Currency('EUR');

if ($collection->contains($currency)) {
    echo 'Yes!';
}

$isInCollection = $collection->contains($otherCurrency);

?>
