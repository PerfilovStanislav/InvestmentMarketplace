<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class CurrencyType implements ConstantInterface {
    use Collection;

    public CONST
        usd = 1,
        eur = 2,
        btc = 3,
        rub = 4,
        gbp = 5,
        jpy = 6,
        won = 7,
        inr = 8;
}
