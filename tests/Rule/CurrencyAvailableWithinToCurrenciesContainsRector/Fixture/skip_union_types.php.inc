<?php

namespace Rector\Money\Tests\Rule\CurrencyAvailableWithinToCurrenciesContainsRector\Fixture;

use Money\Currencies\CurrencyList;
use Money\Currency;
use function mt_rand;

/**
 * @return Currency|array|false
 */
function willReturnCurrencyOrSomethingDifferent() {
    $random = mt_rand(0, 10);
    if ($random % 3 === 0) {
        return new Currency('EUR');
    }
    if ($random === 5) {
        return ['some' => 'other', 'data'];
    }
    return false;
}

$collection = new CurrencyList([new Currency('PLN')]);
willReturnCurrencyOrSomethingDifferent()
    ->isAvailableWithin($collection);

?>

