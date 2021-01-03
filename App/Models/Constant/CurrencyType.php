<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

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

    public static array $symbols = [
        self::USD => '$',
        self::EUR => '€',
        self::BTC => '₿',
        self::RUB => '₽',
        self::GBP => '£',
        self::JPY => '¥',
        self::WON => '￦',
        self::INR => '₹',
    ];
}
