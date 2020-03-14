<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class CurrencyType implements ConstantInterface {
    use Collection;

    public CONST
        USD = 1,
        EUR = 2,
        BTC = 3,
        RUB = 4,
        GBP = 5,
        JPY = 6,
        WON = 7,
        INR = 8;
}
